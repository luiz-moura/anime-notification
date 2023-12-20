<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\AnimeRepository as AnimeRepositoryContract;
use Domain\Animes\DTOs\AnimesData;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use Domain\Animes\DTOs\Models\AnimesModelData;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\Anime;

class AnimeRepository extends Repository implements AnimeRepositoryContract
{
    protected $modelClass = Anime::class;

    public function findBySlug(string $animeSlug): AnimesModelData
    {
        return AnimesModelData::fromModel(
            $this->model->where('slug', $animeSlug)->firstOrFail()->toArray()
        );
    }

    public function create(AnimesData $animes): AnimesModelData
    {
        return AnimesModelData::fromModel(
            $this->model->create($animes->toArray())->toArray()
        );
    }

    public function queryWillBeBroadcastToday(): ?AnimesCollection
    {
        $animes = $this->model->select()
            ->with('titles')
            ->whereRelation('broadcast', 'day', today()->day)
            ->get();

        return $animes
            ? AnimesCollection::fromModel($animes->toArray())
            : null;
    }

    public function queryByMalIds(array $ids): ?AnimesCollection
    {
        $animes = $this->model->select()
            ->whereIn('mal_id', $ids)
            ->get();

        return $animes
            ? AnimesCollection::fromModel($animes->toArray())
            : null;
    }

    public function updateMemberType(int $animeId, int $userId, SubscriptionTypesEnum $type): void
    {
        $this->model->findOrFail($animeId)
            ->users()
            ->updateExistingPivot($userId, ['type' => $type]);
    }

    public function associateTheUser(int $animeId, int $userId, SubscriptionTypesEnum $type): void
    {
        $this->model->find($animeId)->users()->attach($userId, ['type' => $type]);
    }

    public function attachImages(int $animeId, int|array $imageIds): void
    {
        $this->model->find($animeId)->images()->attach($imageIds);
    }

    public function attachGenres(int $animeId, int|array $genreIds): void
    {
        $this->model->find($animeId)->genres()->attach($genreIds);
    }
}
