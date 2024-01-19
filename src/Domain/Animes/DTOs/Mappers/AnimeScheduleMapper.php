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
            'mondays' => new AnimesCollection($schedule['mondays'] ?? null),
            'tuesdays' => new AnimesCollection($schedule['tuesdays'] ?? null),
            'wednesdays' => new AnimesCollection($schedule['wednesdays'] ?? null),
            'thursdays' => new AnimesCollection($schedule['thursdays'] ?? null),
            'fridays' => new AnimesCollection($schedule['fridays'] ?? null),
            'saturdays' => new AnimesCollection($schedule['saturdays'] ?? null),
            'sundays' => new AnimesCollection($schedule['sundays'] ?? null),
            'unknown' => new AnimesCollection($schedule['unknown'] ?? null),
        ];
    }
}
