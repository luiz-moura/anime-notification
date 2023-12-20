<?php

namespace Interfaces\Console\Commands;

use App\Jobs\SearchForAnimesAiringOnTheDaysOfTheWeekJob;
use Illuminate\Console\Command;

class RegisterAnimeThatAreAiring extends Command
{
    protected $signature = 'app:register-anime-airing';

    protected $description = 'Search animes airing from the api and register them in the database';

    public function handle(): void
    {
        SearchForAnimesAiringOnTheDaysOfTheWeekJob::dispatch();
    }
}
