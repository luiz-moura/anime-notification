<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeSubscriptionRepository;
use Domain\Animes\DTOs\AnimeScheduleData;
use Domain\Animes\DTOs\Collections\AnimesCollection as AnimesModelCollection;
use Domain\Animes\DTOs\Collections\SubscriptionsCollection;
use Domain\Animes\DTOs\MemberScheduleData;
use Domain\Animes\UseCases\GetMemberScheduleUseCase;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\SubscriptionDataMock;

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

    public function testShouldReturnTheAnimeScheduleAndUserSubscriptions()
    {
        $animesOnTheSchedule = new AnimesModelCollection([
            AnimeModelDataMock::create(),
            AnimeModelDataMock::create(),
        ]);

        $subscriptions = new SubscriptionsCollection([
            SubscriptionDataMock::create(['anime_id' => $animesOnTheSchedule[0]->id]),
            SubscriptionDataMock::create(['anime_id' => $animesOnTheSchedule[1]->id]),
        ]);

        $response = MemberScheduleData::fromArray([
            'animeSchedule' => AnimeScheduleData::fromAnimesCollection($animesOnTheSchedule),
            'subscriptions' => $subscriptions,
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
