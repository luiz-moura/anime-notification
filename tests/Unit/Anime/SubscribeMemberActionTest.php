<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\SubscribeMemberAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Domain\Animes\DTOs\Models\MemberModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\MemberModelDataMock;
use PHPUnit\Framework\TestCase;

class SubscribeMemberActionTest extends TestCase
{
    public $animeRepository;
    public $memberRepository;
    public $subscribeMemberAction;
    public AnimeModelData $anime;
    public MemberModelData $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animeRepository = $this->createMock(AnimeRepository::class);
        $this->memberRepository = $this->createMock(MemberRepository::class);

        $this->subscribeMemberAction = new SubscribeMemberAction(
            $this->animeRepository,
            $this->memberRepository
        );

        $this->anime = AnimeModelDataMock::create();
        $this->member = MemberModelDataMock::create(['type' => SubscriptionTypesEnum::PLAN_TO_WATCH]);
    }

    public function test_shouldnt_do_anything_when_the_user_is_already_a_member()
    {
        $this->memberRepository
            ->expects($this->once())
            ->method('findByIdAndAnimeId')
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
            ->method('findByIdAndAnimeId')
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
            ->method('findByIdAndAnimeId')
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
