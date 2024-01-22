<?php

namespace Domain\Animes\DTOs\Mappers;

class BroadcastModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'day' => $data['day'] ?? null,
            'time' => $data['time'] ?? null,
            'timezone' => $data['timezone'] ?? null,
            'date_formatted' => $data['date_formatted'] ?? null,
        ];
    }
}
