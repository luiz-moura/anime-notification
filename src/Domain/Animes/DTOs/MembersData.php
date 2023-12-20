<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\Enums\SubscriptionTypesEnum;
use Infra\Abstracts\DataTransferObject;

class MembersData extends DataTransferObject
{
	public function __construct(
        public string $name,
	    public string $email,
	    public ?string $fcm_token,
        public SubscriptionTypesEnum $type,
    ) {}
}
