<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\DefineTimesToQueryAnimesByTimeInTheScheduleAction;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class DefineTimesToQueryAnimesByTimeInTheScheduleActionTest extends TestCase
{
    private DefineTimesToQueryAnimesByTimeInTheScheduleAction $sut;
    private Carbon $today;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new DefineTimesToQueryAnimesByTimeInTheScheduleAction();

        Carbon::setTestNow(now());
        $this->today = today();
    }

    public function testShouldDefineTheTimeForAnimeQueryInTheDaySchedule(): void
    {
        $this->sut->run(function ($beginning, $end): void {
            $current = $this->today->toImmutable();

            $this->assertTrue(Carbon::createFromDate($beginning)->equalTo($current));
            $this->assertTrue(Carbon::createFromDate($end)->equalTo($current->endOfHour()));

            $this->today->addHour();
        });
    }
}
