<?php

namespace Interfaces\Http\Web\Member\Controller;

use Domain\Animes\Actions\SubscribeMemberAction;
use Domain\Animes\Actions\UnsubscribeMemberAction;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\Controller;

class SubscriptionController extends Controller
{
    public function subscribeMember(
        int $animeId,
        SubscribeMemberAction $subscribeMemberAction
    ) {
        $userId = auth()->user()->id;

        $subscribeMemberAction->run($animeId, $userId, SubscriptionTypesEnum::WATCHING);

        return response()->noContent();
    }

    public function unsubscribeMember(
        int $animeId,
        UnsubscribeMemberAction $unsubscribeMemberAction
    ) {
        $userId = auth()->user()->id;

        $unsubscribeMemberAction->run($animeId, $userId);

        return response()->noContent();
    }
}
