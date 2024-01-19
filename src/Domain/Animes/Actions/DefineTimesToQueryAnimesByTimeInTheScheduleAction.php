<?php

namespace Domain\Animes\Actions;

class DefineTimesToQueryAnimesByTimeInTheScheduleAction
{
    public function run(callable $callback): void
    {
        $today = today();

        for ($i = 0; $i <= 23; $i++) {
            $current = $today->toImmutable();

            $callback(beginning: $current, end: $current->endOfHour());

            $today->addHour();
        }
    }
}
