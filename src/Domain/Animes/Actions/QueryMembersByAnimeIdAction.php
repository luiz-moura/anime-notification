<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Collections\MembersCollection;

class QueryMembersByAnimeIdAction
{
    public function __construct(private MemberRepository $memberRepository) {}

    public function run(int $animeId): MembersCollection
    {
        return $this->memberRepository->queryByAnimeId($animeId);
    }
}
