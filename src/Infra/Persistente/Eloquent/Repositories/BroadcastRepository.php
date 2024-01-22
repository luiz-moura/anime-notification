<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\BroadcastRepository as BroadcastRepositoryContract;
use Domain\Animes\DTOs\BroadcastData;
use Domain\Animes\DTOs\Models\BroadcastModelData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\Broadcast;

class BroadcastRepository extends Repository implements BroadcastRepositoryContract
{
    protected $modelClass = Broadcast::class;

    public function create(int $animeId, BroadcastData $broadcast): BroadcastModelData
    {
        return BroadcastModelData::fromModel(
            $this->model->create($broadcast->toArray() + ['anime_id' => $animeId])->toArray()
        );
    }
}
