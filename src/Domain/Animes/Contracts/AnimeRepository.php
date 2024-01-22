<?php

namespace Domain\Animes\Contracts;

use DateTime;
use Domain\Animes\DTOs\AnimeData;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;

interface AnimeRepository
{
    public function queryByMalIds(array $ids): AnimesCollection;
    public function queryByBroadcsatTimeRange(DateTime $beginning, DateTime $end): AnimesCollection;
    public function queryByCurrentSeason(): AnimesCollection;
    public function queryAiringByDayExceptMalIds(string $day, array $malIds): AnimesCollection;
    public function create(AnimeData $animes): AnimeModelData;
    public function findById(int $id): AnimeModelData;
    public function updateAiringStatusByMalIds(array $malIds, bool $status): void;
    public function updateMemberType(int $animeId, int $userId, SubscriptionTypesEnum $type): void;
    public function associateTheUser(int $animeId, int $userId, SubscriptionTypesEnum $type): void;
    public function disassociateTheUser(int $animeId, int $userId): void;
    public function attachImages(int $animeId, int|array $imageIds): void;
    public function attachGenres(int $animeId, int|array $genreIds): void;
}
