<?php

namespace Interfaces\Http\Web\Member\Controller;

use Domain\Animes\Actions\CreateNotificationTokenForMemberAction;
use Domain\Animes\DTOs\NotificationTokenData;
use Infra\Abstracts\Controller;
use Interfaces\Http\Web\Member\Requests\NotificationSetTokenRequest;

class NotificationController extends Controller
{
    public function setToken(
        NotificationSetTokenRequest $request,
        CreateNotificationTokenForMemberAction $createNotificationTokenForMemberAction
    ) {
        $createNotificationTokenForMemberAction->run(
            NotificationTokenData::fromArray([
                'token' => $request->input('token'),
                'user_agent' => $request->header('User-Agent'),
                'user_id' => $request->user()->id,
            ])
        );

        return response()->noContent();
    }
}
