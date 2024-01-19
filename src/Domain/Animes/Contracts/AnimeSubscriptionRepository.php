<?php

namespace Domain\Animes\Contracts;

use Domain\Animes\DTOs\Collections\SubscriptionsCollection;

interface AnimeSubscriptionRepository
{
    public function queryByMemberId(int $memberId): SubscriptionsCollection;
}
