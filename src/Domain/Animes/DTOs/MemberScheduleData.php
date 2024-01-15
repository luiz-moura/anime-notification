<?php
namespace Domain\Animes\DTOs;

use Domain\Animes\DTOs\Collections\SubscriptionsCollection;
use Infra\Abstracts\DataTransferObject;

class MemberScheduleData extends DataTransferObject
{
    public function __construct(
        public AnimeScheduleData $animeSchedule,
        public SubscriptionsCollection $subscriptions
    ) {}
}
