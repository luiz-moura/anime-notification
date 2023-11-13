<?php

namespace Infra\Api\Contracts;

use Infra\Api\DTOs\Collections\AnimesCollection;

interface AnimeApiService
{
    public function searchByTerm(string $term): AnimesCollection;
    public function getSchedulesByDay(string $day): AnimesCollection;
}
