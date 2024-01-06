<?php

namespace Infra\Integration\Firebase;

use Infra\Integration\Messaging\Contracts\NoticationService;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseService implements NoticationService
{
    public function sendMessage(array $tokens, string $title, string $message, ?string $imageUrl = null): void
    {
        $message = CloudMessage::new()->fromArray([
            'notification' => [
                'title' => $title,
                'body' => $message,
                "image" => $imageUrl
            ],
        ]);

        $this->messaging()->sendMulticast($message, $tokens);
    }

    private function messaging()
    {
        return app(Messaging::class);
    }
}
