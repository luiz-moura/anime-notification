<?php

namespace Infra\Integration\Messaging\Contracts;

interface NoticationService
{
    public function sendMessage(array $tokens, string $title, string $message, string $imageUrl): void;
}
