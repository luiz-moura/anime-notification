<?php
namespace Domain\Animes\UseCases;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeSubscriptionRepository;
use Domain\Animes\DTOs\AnimeScheduleData;
use Domain\Animes\DTOs\MemberScheduleData;

class GetMemberScheduleUseCase {
    public function __construct(
        private AnimeSubscriptionRepository $animeSubscriptionRepository,
        private AnimeRepository $animeRepository
    ) {}

    public function run(int $memberId): MemberScheduleData
    {
        $animesOnTheSchedule = $this->animeRepository->queryByCurrentSeason();
        $subscriptions = $this->animeSubscriptionRepository->queryByMemberId($memberId);

        return MemberScheduleData::fromArray([
            'animeSchedule' => AnimeScheduleData::fromAnimeCollection($animesOnTheSchedule),
            'subscriptions' => $subscriptions
        ]);
    }
}
