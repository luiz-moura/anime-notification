<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\DefineTimesToQueryAnimesByTimeInTheScheduleAction;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class DefineTimesToQueryAnimesByTimeInTheScheduleActionTest extends TestCase
{
    private $today;
    private $defineTimesToQueryAnimesByTimeInTheScheduleAction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defineTimesToQueryAnimesByTimeInTheScheduleAction = new DefineTimesToQueryAnimesByTimeInTheScheduleAction();

        Carbon::setTestNow(now());
        $this->today = today();
    }

    public function test_should_define_the_time_for_anime_query_in_the_day_schedule()
    {
        $this->defineTimesToQueryAnimesByTimeInTheScheduleAction->run(function ($beginning, $end) {
            $current = $this->today->toImmutable();

            $this->assertTrue(Carbon::createFromDate($beginning)->equalTo($current));
            $this->assertTrue(Carbon::createFromDate($end)->equalTo($current->endOfHour()));

            $this->today->addHour();
        });
    }
}
