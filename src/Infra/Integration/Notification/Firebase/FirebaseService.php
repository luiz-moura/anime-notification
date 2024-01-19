<?php

namespace Infra\Integration\Notification\Firebase;

use Infra\Integration\Notification\Contracts\NoticationService;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService implements NoticationService
{
    public function sendMessage(array $tokens, string $title, string $message, ?string $imageUrl = null): void
    {
        $message = CloudMessage::new()->withNotification(
            Notification::create($title, $message, $imageUrl)
        );

        $this->messaging()->sendMulticast($message, $tokens);
    }

    private function messaging(): Messaging
    {
        return app(Messaging::class);
    }
}
