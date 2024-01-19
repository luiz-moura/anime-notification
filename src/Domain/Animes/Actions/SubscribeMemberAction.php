<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class SubscribeMemberAction
{
    public function __construct(
        private AnimeRepository $animeRepository,
        private MemberRepository $memberRepository,
    ) {}

    public function run(string $animeId, int $userId, SubscriptionTypesEnum $type): void
    {
        $member = $this->memberRepository->findByIdAndAnimeId($userId, $animeId);

        if ($member && $member->type === $type) {
            return;
        }

        if ($member) {
            $this->animeRepository->updateMemberType($animeId, $member->id, $type);

            return;
        }

        $this->animeRepository->associateTheUser($animeId, $userId, $type);
    }
}
