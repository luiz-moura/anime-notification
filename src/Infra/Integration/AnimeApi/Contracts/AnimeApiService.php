<?php

namespace Infra\Integration\AnimeApi\Contracts;

use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection;

interface AnimeApiService
{
    public function getSchedulesByDay(string $day): AnimesCollection;
}
