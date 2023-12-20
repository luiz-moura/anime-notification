<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\Enums\SubscriptionTypesEnum;

class BecomeAnAnimeMemberAction
{
    public function __construct(
        private AnimeRepository $animeRepository,
        private MemberRepository $memberRepository,
    ) {}

    public function run(string $animeSlug, int $userId, SubscriptionTypesEnum $type): void
    {
        $anime = $this->animeRepository->findBySlug($animeSlug);
        $member = $this->memberRepository->queryByIdAndAnimeId($userId, $anime->id);

        if ($member && $member->type === $type) {
            return;
        }

        if ($member) {
            $this->animeRepository->updateMemberType($anime->id, $member->id, $type);

            return;
        }

        $this->animeRepository->associateTheUser($anime->id, $userId, $type);
    }
}
