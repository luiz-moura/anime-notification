<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\MemberRepository as MemberRepositoryContract;
use Domain\Animes\DTOs\Collections\MembersCollection;
use Domain\Animes\DTOs\Models\MemberModelData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\User;

class UserRepository extends Repository implements MemberRepositoryContract
{
    protected $modelClass = User::class;

    public function queryByAnimeId(int $animeId): MembersCollection
    {
        return MembersCollection::fromModel(
            $this->model->query()
                ->with([
                    'fcm_tokens',
                    'animes' => fn ($query): mixed => $query->where('id', $animeId),
                ])
                ->whereRelation('animes', 'id', $animeId)
                ->get()
                ?->toArray()
        );
    }

    public function findByIdAndAnimeId(int $userId, int $animeId): ?MemberModelData
    {
        $member = $this->model->query()
            ->where('id', $userId)
            ->with(['animes' => fn ($query): mixed => $query->where('id', $animeId)])
            ->whereRelation('animes', 'id', $animeId)
            ->first();

        return $member
            ? MemberModelData::fromModel($member->toArray())
            : null;
    }
}
