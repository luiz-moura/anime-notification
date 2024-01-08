<?php

namespace Interfaces\Http\Api\Animes\Controllers;

use Domain\Animes\Actions\BecomeAnAnimeMemberAction;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\Controller;

class AnimeController extends Controller
{
    public function becomeMember(
        string $animeSlug,
        BecomeAnAnimeMemberAction $becomeAnAnimeMemberAction
    ) {
        $userId = auth()->user()->id;

        $becomeAnAnimeMemberAction->run($animeSlug, $userId, SubscriptionTypesEnum::WATCHING);

        return response()->noContent();
    }
}
