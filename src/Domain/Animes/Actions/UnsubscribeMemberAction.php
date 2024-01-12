<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\MemberRepository;

class UnsubscribeMemberAction
{
    public function __construct(
        private AnimeRepository $animeRepository,
        private MemberRepository $memberRepository,
    ) {}

    public function run(string $animeId, int $userId): void
    {
        $this->animeRepository->disassociateTheUser($animeId, $userId);
    }
}
