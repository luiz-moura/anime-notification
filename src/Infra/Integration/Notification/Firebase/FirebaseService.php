<?php

namespace Infra\Integration\Notification\Firebase;

use Infra\Integration\Notification\Contracts\NotificationService;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService implements NotificationService
{
    public function __construct(public Messaging $messaging)
    {
    }

    public function sendMessage(array $tokens, string $title, string $message, string $imageUrl = null): void
    {
        $message = CloudMessage::new()->withNotification(
            Notification::create($title, $message, $imageUrl)
        );

        $this->messaging()->sendMulticast($message, $tokens);
    }

    public function messaging()
    {
        return app('firebase.messaging');
    }
}
