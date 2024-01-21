<?php

namespace Domain\Animes\DTOs\Mappers;

class NotificationTokenModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'user_id' => $data['user_id'],
            'user_agent' => $data['user_agent'],
            'token' => $data['token'],
        ];
    }
}
