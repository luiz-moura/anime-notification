<?php

namespace Interfaces\Console\Commands;

use App\Jobs\ImportAnimesFromApiJob;
use Illuminate\Console\Command;

class ImportAnimes extends Command
{
    protected $signature = 'app:import-animes';

    protected $description = 'Search animes airing from the api and register them in the database';

    public function handle(): void
    {
        ImportAnimesFromApiJob::dispatch();
    }
}
