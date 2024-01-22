<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\NotificationTokenData;

interface NotificationTokenRepository
{
    public function create(NotificationTokenData $memberToken): void;

    public function tokenAlreadyExists(string $token): bool;
}
