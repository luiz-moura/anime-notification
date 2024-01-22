<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\Collections\MembersCollection;
use Domain\Animes\DTOs\Models\MemberModelData;

interface MemberRepository
{
    public function queryByAnimeId(int $animeId): MembersCollection;

    public function findByIdAndAnimeId(int $userId, int $animeId): ?MemberModelData;
}
