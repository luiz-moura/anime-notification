<?php

namespace Domain\Animes\Actions;

class DefineTimeForQueryAnimeThatWillBeBroadcastTodayAction
{
    public function run(callable $callback): void
    {
        $start = today()->timezone('Asia/Tokyo');

        for ($i = 0; $i <= 23; $i++) {
            $begin = $start->clone();
            $ending = $start->addHour();

            if ($i > 0) {
                $begin->addMinute();
            }

            $callback();
        }
    }
}
