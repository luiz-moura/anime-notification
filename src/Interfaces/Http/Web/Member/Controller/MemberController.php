<?php

namespace Interfaces\Http\Web\Member\Controller;

use Domain\Animes\UseCases\GetTheMemberScheduleUseCase;
use Inertia\Inertia;
use Inertia\Response;
use Infra\Abstracts\Controller;

class MemberController extends Controller
{
    public function schedule(GetTheMemberScheduleUseCase $getTheMemberScheduleUseCase): Response
    {
        $userId = auth()->user()->id;
        $memberSchedule = $getTheMemberScheduleUseCase->run($userId);

        return Inertia::render('Schedule', [
            'animes' => $memberSchedule->animes,
            'subscriptions' => $memberSchedule->subscriptions
        ]);
    }
}
