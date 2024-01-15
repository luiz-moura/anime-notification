<?php

namespace Domain\Animes\DTOs\Mappers;

use Domain\Animes\DTOs\Collections\AnimesCollection;

class AnimeScheduleMapper
{
    public static function fromAnimeCollection(AnimesCollection $animes): array
    {
        $schedule = collect($animes)->groupBy(
            fn ($anime) => strtolower($anime->broadcast->day ?? 'unknown')
        )->all();

        return [
            'mondays' => new AnimesCollection($schedule['mondays']),
            'tuesdays' => new AnimesCollection($schedule['tuesdays']),
            'wednesdays' => new AnimesCollection($schedule['wednesdays']),
            'thursdays' => new AnimesCollection($schedule['thursdays']),
            'fridays' => new AnimesCollection($schedule['fridays']),
            'saturdays' => new AnimesCollection($schedule['saturdays']),
            'sundays' => new AnimesCollection($schedule['sundays']),
            'unknown' => new AnimesCollection($schedule['unknown']),
        ];
    }
}
