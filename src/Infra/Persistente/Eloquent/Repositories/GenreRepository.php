<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\GenreRepository as GenreRepositoryContract;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\GenreData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\Genre;

class GenreRepository extends Repository implements GenreRepositoryContract
{
    protected $modelClass = Genre::class;

    public function create(GenreData $genre): void
    {
        $this->model->create($genre->toArray());
    }

    public function queryByMalIds(array $ids): GenresCollection
    {
        return GenresCollection::fromModel(
            $this->model->query()
                ->whereIn('mal_id', $ids)
                ->get()
                ?->toArray()
        );
    }
}
