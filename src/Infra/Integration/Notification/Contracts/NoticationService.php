<?php

namespace Infra\Integration\Notification\Contracts;

interface NoticationService
{
    public function sendMessage(array $tokens, string $title, string $message, string $imageUrl): void;
}
