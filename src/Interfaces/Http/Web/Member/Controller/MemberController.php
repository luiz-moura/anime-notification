<?php

namespace Interfaces\Http\Web\Member\Controller;

use Domain\Animes\UseCases\GetMemberScheduleUseCase;
use Inertia\Inertia;
use Inertia\Response;
use Infra\Abstracts\Controller;

class MemberController extends Controller
{
    public function schedule(GetMemberScheduleUseCase $getMemberScheduleUseCase): Response
    {
        $userId = auth()->user()->id;
        $memberSchedule = $getMemberScheduleUseCase->run($userId);

        return Inertia::render('Schedule', [
            'animeSchedule' => $memberSchedule->animeSchedule,
            'subscriptions' => $memberSchedule->subscriptions
        ]);
    }
}
