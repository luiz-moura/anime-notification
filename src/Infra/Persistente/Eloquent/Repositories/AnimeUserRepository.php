<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\AnimeSubscriptionRepository as AnimeSubscriptionRepositoryContract;
use Domain\Animes\DTOs\Collections\SubscriptionsCollection;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\AnimeUser;

class AnimeUserRepository extends Repository implements AnimeSubscriptionRepositoryContract
{
    protected $modelClass = AnimeUser::class;

    public function queryByMemberId(int $memberId): SubscriptionsCollection
    {
        return SubscriptionsCollection::fromModel(
            $this->model->where('user_id', $memberId)->get()?->toArray()
        );
    }
}
