<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\MemberRepository as MemberRepositoryContract;
use Domain\Animes\DTOs\Collections\MembersCollection;
use Domain\Animes\DTOs\Models\MembersModelData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\User;

class UserRepository extends Repository implements MemberRepositoryContract
{
    protected $modelClass = User::class;

    public function queryByAnimeId(int $animeId): ?MembersCollection
    {
        $users = $this->model->select()
            ->with([
                'animes' => fn ($query) => $query->where('id', $animeId)
            ])
            ->whereRelation('animes', 'id', $animeId)
            ->get();

        return $users
            ? MembersCollection::fromModel($users->toArray())
            : null;
    }

    public function queryByIdAndAnimeId(int $userId, int $animeId): ?MembersModelData
    {
        $user = $this->model->select()
            ->where('id', $userId)
            ->with([
                'animes' => fn ($query) => $query->where('id', $animeId)
            ])
            ->whereRelation('animes', 'id', $animeId)
            ->first();

        return $user
            ?  MembersModelData::fromModel($user->toArray())
            : null;
    }
}
