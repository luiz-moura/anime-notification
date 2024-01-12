<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\SubscribeMemberAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Models\AnimesModelData;
use Domain\Animes\DTOs\Models\MembersModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Tests\Mocks\AnimesModelDataMock;
use Tests\Mocks\MembersModelDataMock;
use PHPUnit\Framework\TestCase;

class SubscribeMemberActionTest extends TestCase {
    public $animeRepository;
    public $memberRepository;
    public $subscribeMemberAction;
    public AnimesModelData $anime;
    public MembersModelData $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animeRepository = $this->createMock(AnimeRepository::class);
        $this->memberRepository = $this->createMock(MemberRepository::class);

        $this->subscribeMemberAction = new SubscribeMemberAction(
            $this->animeRepository,
            $this->memberRepository
        );

        $this->anime = AnimesModelDataMock::create();
        $this->member = MembersModelDataMock::create(['type' => SubscriptionTypesEnum::PLAN_TO_WATCH]);
    }

    public function test_shouldnt_do_anything_when_the_user_is_already_a_member()
    {
        $this->memberRepository
            ->expects($this->once())
            ->method('queryByIdAndAnimeId')
            ->with($this->member->id, $this->anime->id)
            ->willReturn($this->member);

        $this->animeRepository
            ->expects($this->never())
            ->method('updateMemberType');

        $this->animeRepository
            ->expects($this->never())
            ->method('associateTheUser');

        $this->subscribeMemberAction->run($this->anime->id, $this->member->id, SubscriptionTypesEnum::PLAN_TO_WATCH);
    }

    public function test_should_change_the_type_of_member_subscription()
    {
        $subscription = SubscriptionTypesEnum::PLAN_TO_WATCH;

        $this->member->type = SubscriptionTypesEnum::DROPPED;

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByIdAndAnimeId')
            ->with($this->member->id, $this->anime->id)
            ->willReturn($this->member);

        $this->animeRepository
            ->expects($this->once())
            ->method('updateMemberType')
            ->with($this->anime->id, $this->member->id, $subscription);

        $this->animeRepository
            ->expects($this->never())
            ->method('associateTheUser');

        $this->subscribeMemberAction->run($this->anime->id, $this->member->id, $subscription);
    }

    public function test_should_become_a_member_successfully()
    {
        $subscription = SubscriptionTypesEnum::PLAN_TO_WATCH;

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByIdAndAnimeId')
            ->with($this->member->id, $this->anime->id)
            ->willReturn(null);

        $this->animeRepository
            ->expects($this->never())
            ->method('updateMemberType');

        $this->animeRepository
            ->expects($this->once())
            ->method('associateTheUser')
            ->with($this->anime->id, $this->member->id, $subscription);

        $this->subscribeMemberAction->run($this->anime->id, $this->member->id, $subscription);
    }
}
