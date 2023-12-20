<?php

namespace Domain\Animes\Enums;

enum SubscriptionTypesEnum: string
{
    case WATCHING = 'watching';
    case COMPLETED = 'completed';
    case ON_HOLD = 'on_hold';
    case DROPPED = 'dropped';
    case PLAN_TO_WATCH = 'plan_to_watch';
}
