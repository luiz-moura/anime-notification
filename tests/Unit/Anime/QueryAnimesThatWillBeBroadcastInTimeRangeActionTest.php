<?php

namespace Tests\Unit\Anime;

use Carbon\Carbon;
use Domain\Animes\Actions\QueryAnimesThatWillBeBroadcastInTimeRangeAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\BroadcastModelDataMock;

class QueryAnimesThatWillBeBroadcastInTimeRangeActionTest extends TestCase
{
    private $animeRepository;
    private $beginning;
    private $end;
    private $animes;
    private $queryAnimesThatWillBeBroadcastInTimeRangeAction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animeRepository = $this->createMock(AnimeRepository::class);

        $this->queryAnimesThatWillBeBroadcastInTimeRangeAction = new QueryAnimesThatWillBeBroadcastInTimeRangeAction(
            $this->animeRepository,
        );

        $this->beginning = now();
        $this->end = now()->addHour();

        $anime = AnimeModelDataMock::create();
        $anime->broadcast = BroadcastModelDataMock::create(['time' => '10:00:00']);
        $this->animes = new AnimesCollection([
            $anime,
        ]);
    }

    public function testShouldReturnUnregisteredAnimesAndThoseThatLeftTheSchedule()
    {
        $this->animeRepository
            ->expects($this->once())
            ->method('queryByBroadcsatTimeRange')
            ->with($this->beginning, $this->end)
            ->willReturn($this->animes);

        $this->queryAnimesThatWillBeBroadcastInTimeRangeAction->run($this->beginning, $this->end, function ($anime, $timeLeftToBeTransmitted) {
            Carbon::setTestNowAndTimezone(now());
            $broadcastTime = Carbon::createFromFormat('H:i:s', $anime->broadcast->time);
            $timeLeftToBeTransmittedTest = now()->diffInSeconds($broadcastTime);

            $this->assertEquals($anime, $this->animes->first());
            $this->assertEquals($timeLeftToBeTransmitted, $timeLeftToBeTransmittedTest);
        });
    }

    public function testShouldNotRunARoutineWhenNotFoundAnyAnime()
    {
        $animes = new AnimesCollection();

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByBroadcsatTimeRange')
            ->with($this->beginning, $this->end)
            ->willReturn($animes);

        $this->queryAnimesThatWillBeBroadcastInTimeRangeAction->run($this->beginning, $this->end, fn () => null);
    }
}
