<?php

namespace Domain\Animes\Actions;

class DefineTimesToQueryAnimesByTimeInTheScheduleAction
{
    public function run(callable $callback): void
    {
        $today = today()->startOfDay();

        for ($i = 0; $i <= 23; $i++) {
            $current = $today->toImmutable();

            $callback(beginning: $current->toDateTime(), end: $current->endOfHour()->toDateTime());

            $today->addHour();
        }
    }
}
