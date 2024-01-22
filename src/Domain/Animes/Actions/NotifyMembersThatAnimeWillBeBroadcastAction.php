<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Infra\Helpers\UrlHelper;
use Infra\Integration\Notification\Contracts\NoticationService;

class NotifyMembersThatAnimeWillBeBroadcastAction
{
    public function __construct(
        private MemberRepository $memberRepository,
        private NoticationService $noticationService,
        private UrlHelper $urlHelper
    ) {}

    public function run(AnimeModelData $anime): void
    {
        $members = $this->memberRepository->queryByAnimeId($anime->id);

        if ($members->isEmpty()) {
            return;
        }

        $tokens = collect($members)->pluck('notification_tokens')
            ->collapse()
            ->pluck('token')
            ->all();

        if (!$tokens) {
            return;
        }

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
