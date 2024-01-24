<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\DTOs\Collections\NotificationTokensCollection;
use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\DataTransferObject;

class MemberData extends DataTransferObject
{
    public function __construct(
        public string $name,
        public string $email,
        public SubscriptionTypesEnum $type,
        public ?NotificationTokensCollection $notification_tokens,
    ) {
    }
}
