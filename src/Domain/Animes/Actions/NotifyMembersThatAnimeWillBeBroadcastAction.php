<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Models\AnimesModelData;
use Infra\Helpers\UrlHelper;
use Infra\Integration\Notification\Contracts\NoticationService;

class NotifyMembersThatAnimeWillBeBroadcastAction
{
    public function __construct(
        private MemberRepository $memberRepository,
        private NoticationService $noticationService,
        private UrlHelper $urlHelper
    ) {}

    public function run(AnimesModelData $anime): void
    {
        $members = $this->memberRepository->queryByAnimeId($anime->id);
        $tokens = collect($members)->pluck('fcm_token')->all();

        $this->noticationService->sendMessage(
            $tokens,
            title: 'New episode released',
            message: "New {$anime->title} episode released",
            imageUrl: $anime->images
                ? $this->urlHelper->url($anime->images->first()->path)
                : null
        );
    }
}
