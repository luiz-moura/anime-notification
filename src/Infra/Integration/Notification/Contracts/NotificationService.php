<?php

namespace Infra\Integration\Notification\Contracts;

interface NotificationService
{
    public function sendMessage(array $tokens, string $title, string $message, ?string $imageUrl = null): void;
}
