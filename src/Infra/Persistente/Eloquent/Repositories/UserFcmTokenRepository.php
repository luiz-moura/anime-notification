<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Animes\Contracts\NotificationTokenRepository;
use Domain\Animes\DTOs\NotificationTokenData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\UserFcmToken;

class UserFcmTokenRepository extends Repository implements NotificationTokenRepository
{
    protected $modelClass = UserFcmToken::class;

    public function create(NotificationTokenData $notificationToken): void
    {
        $this->model->create(
            $notificationToken->toArray()
        );
    }

    public function tokenAlreadyExists(string $token): bool
    {
        return $this->model->query()
            ->where('token', $token)
            ->exists();
    }
}
