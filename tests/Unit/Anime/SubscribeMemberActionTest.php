<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\SubscribeMemberAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Domain\Animes\DTOs\Models\MemberModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\MemberModelDataMock;

class SubscribeMemberActionTest extends TestCase
{
    public MockObject|SubscribeMemberAction $sut;
    public MockObject|AnimeRepository $animeRepository;
    public MockObject|MemberRepository $memberRepository;
    public AnimeModelData $anime;
    public MemberModelData $member;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var AnimeRepository */
        $this->animeRepository = $this->createMock(AnimeRepository::class);
        /** @var MemberRepository */
        $this->memberRepository = $this->createMock(MemberRepository::class);

        $this->sut = new SubscribeMemberAction(
            $this->animeRepository,
            $this->memberRepository
        );

        $this->anime = AnimeModelDataMock::create();
        $this->member = MemberModelDataMock::create(['type' => SubscriptionTypesEnum::PLAN_TO_WATCH]);
    }

    public function testShouldntDoAnythingWhenTheUserIsAlreadyAMember(): void
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

        $this->sut->run($this->anime->id, $this->member->id, SubscriptionTypesEnum::PLAN_TO_WATCH);
    }

    public function testShouldChangeTheTypeOfMemberSubscription(): void
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

        $this->sut->run($this->anime->id, $this->member->id, $subscription);
    }

    public function testShouldBecomeAMemberSuccessfully(): void
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

        $this->sut->run($this->anime->id, $this->member->id, $subscription);
    }
}
