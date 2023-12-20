<?php

namespace Domain\Animes\DTOs\Mappers;

class BroadcastsModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'day' => $data['day'],
            'time' => $data['time'],
            'timezone' => $data['timezone'],
            'time_formatted' => $data['time_formatted'],
        ];
    }
}
