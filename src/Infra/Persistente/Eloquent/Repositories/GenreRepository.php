<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\GenreRepository as GenreRepositoryContract;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\GenresData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\Genre;

class GenreRepository extends Repository implements GenreRepositoryContract
{
    protected $modelClass = Genre::class;

    public function create(GenresData $genre): void
    {
        $this->model->create($genre->toArray());
    }

    public function queryByMalIds(array $ids): ?GenresCollection
    {
        $genres = $this->model->select()
            ->whereIn('mal_id', $ids)
            ->get();

        return $genres
            ? GenresCollection::fromModel($genres->toArray())
            : null;
    }
}
