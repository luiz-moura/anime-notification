<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeSubscriptionRepository;
use Domain\Animes\DTOs\AnimeScheduleData;
use Domain\Animes\DTOs\Collections\AnimesCollection as AnimesModelCollection;
use Domain\Animes\DTOs\Collections\SubscriptionsCollection;
use Domain\Animes\DTOs\MemberScheduleData;
use Domain\Animes\UseCases\GetMemberScheduleUseCase;
use Tests\Mocks\AnimesModelDataMock;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\SubscriptionsDataMock;

class GetMemberScheduleUseCaseTest extends TestCase
{
    private $animeSubscriptionRepository;
    private $animeRepository;
    private $getMemberScheduleUseCase;
    private $memberId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animeSubscriptionRepository = $this->createMock(AnimeSubscriptionRepository::class);
        $this->animeRepository = $this->createMock(AnimeRepository::class);

        $this->getMemberScheduleUseCase = new GetMemberScheduleUseCase(
            $this->animeSubscriptionRepository,
            $this->animeRepository
        );

        $this->memberId = fake()->randomNumber();
    }

    public function test_should_return_the_anime_schedule_and_user_subscriptions()
    {
        $animesOnTheSchedule = new AnimesModelCollection([
            AnimesModelDataMock::create(),
            AnimesModelDataMock::create(),
        ]);

        $subscriptions = new SubscriptionsCollection([
            SubscriptionsDataMock::create(['anime_id' => $animesOnTheSchedule[0]->id]),
            SubscriptionsDataMock::create(['anime_id' => $animesOnTheSchedule[1]->id]),
        ]);

        $response = MemberScheduleData::fromArray([
            'animeSchedule' => AnimeScheduleData::fromAnimeCollection($animesOnTheSchedule),
            'subscriptions' => $subscriptions
        ]);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByCurrentSeason')
            ->with()
            ->willReturn($animesOnTheSchedule);

        $this->animeSubscriptionRepository
            ->expects($this->once())
            ->method('queryByMemberId')
            ->with($this->memberId)
            ->willReturn($subscriptions);

        $result = $this->getMemberScheduleUseCase->run($this->memberId);

        $this->assertEquals($result, $response);
    }
}
