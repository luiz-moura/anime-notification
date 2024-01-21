<?php

namespace Domain\Animes\Actions;

use Domain\Animes\Contracts\NotificationTokenRepository;
use Domain\Animes\DTOs\NotificationTokenData;

class CreateNotificationTokenForMemberAction
{
    public function __construct(private NotificationTokenRepository $memberNotificationTokenRepository) {}

    public function run(NotificationTokenData $notificationToken): void
    {
        if ($this->memberNotificationTokenRepository->tokenAlreadyExists($notificationToken->token)) {
            return;
        }

        $this->memberNotificationTokenRepository->create($notificationToken);
    }
}
