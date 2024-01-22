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

    public function testShouldDefineTheTimeForAnimeQueryInTheDaySchedule()
    {
        $this->defineTimesToQueryAnimesByTimeInTheScheduleAction->run(function ($beginning, $end) {
            $current = $this->today->toImmutable();

            $this->assertTrue(Carbon::createFromDate($beginning)->equalTo($current));
            $this->assertTrue(Carbon::createFromDate($end)->equalTo($current->endOfHour()));

            $this->today->addHour();
        });
    }
}
