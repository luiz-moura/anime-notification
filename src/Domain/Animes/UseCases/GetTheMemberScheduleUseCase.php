<?php
namespace Domain\Animes\UseCases;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeSubscriptionRepository;
use Domain\Animes\DTOs\AnimeScheduleData;
use Domain\Animes\DTOs\MemberScheduleData;

class GetTheMemberScheduleUseCase {
    public function __construct(
        private AnimeSubscriptionRepository $animeSubscriptionRepository,
        private AnimeRepository $animeRepository
    ) {}

    public function run(int $memberId): MemberScheduleData
    {
        $animes = $this->animeRepository->queryByCurrentSeason();
        $subscriptions = $this->animeSubscriptionRepository->queryByMemberId($memberId);

        return MemberScheduleData::fromArray([
            'animeSchedule' => AnimeScheduleData::fromAnimeCollection($animes),
            'subscriptions' => $subscriptions
        ]);
    }
}
