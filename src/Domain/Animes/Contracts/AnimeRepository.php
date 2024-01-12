<?php

namespace Domain\Animes\Contracts;

use DateTime;
use Domain\Animes\DTOs\AnimesData;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use Domain\Animes\DTOs\Models\AnimesModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;

interface AnimeRepository
{
    public function queryByMalIds(array $ids): ?AnimesCollection;
    public function queryByBroadcsatTimeRange(DateTime $beginning, DateTime $end): ?AnimesCollection;
    public function queryByCurrentSeason(): ?AnimesCollection;
    public function create(AnimesData $animes): AnimesModelData;
    public function findById(int $id): AnimesModelData;
    public function updateMemberType(int $animeId, int $userId, SubscriptionTypesEnum $type): void;
    public function associateTheUser(int $animeId, int $userId, SubscriptionTypesEnum $type): void;
    public function disassociateTheUser(int $animeId, int $userId): void;
    public function attachImages(int $animeId, int|array $imageIds): void;
    public function attachGenres(int $animeId, int|array $genreIds): void;
}
