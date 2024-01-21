<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\DTOs\Collections\NotificationTokenCollection;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\DataTransferObject;

class MembersData extends DataTransferObject
{
    public function __construct(
        public string $name,
        public string $email,
        public SubscriptionTypesEnum $type,
        public NotificationTokenCollection $notification_tokens,
    ) {}
}
