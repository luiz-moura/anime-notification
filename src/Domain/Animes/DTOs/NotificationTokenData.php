<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\DTOs\Mappers\NotificationTokenModelMapper;
use Infra\Abstracts\DataTransferObject;

class NotificationTokenData extends DataTransferObject
{
    public function __construct(
        public int $user_id,
        public string $user_agent,
        public string $token,
    ) {
    }

    public static function fromModel(array $data): self
    {
        return self::fromArray(
            NotificationTokenModelMapper::fromArray($data)
        );
    }
}
