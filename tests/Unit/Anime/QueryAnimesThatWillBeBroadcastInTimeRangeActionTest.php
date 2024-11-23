<?php

namespace Tests\Unit\Anime;

use Carbon\Carbon;
use DateTime;
use Domain\Animes\Actions\QueryAnimesThatWillBeBroadcastInTimeRangeAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\Collections\AnimesCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\BroadcastModelDataMock;

class QueryAnimesThatWillBeBroadcastInTimeRangeActionTest extends TestCase
{
    private QueryAnimesThatWillBeBroadcastInTimeRangeAction $sut;
    private MockObject|AnimeRepository $animeRepository;
    private DateTime $beginning;
    private DateTime $end;
    private AnimesCollection $animes;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var AnimeRepository */
        $this->animeRepository = $this->createMock(AnimeRepository::class);

        $this->sut = new QueryAnimesThatWillBeBroadcastInTimeRangeAction(
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

    public function testShouldReturnUnregisteredAnimesAndThoseThatLeftTheSchedule(): void
    {
        $this->animeRepository
            ->expects($this->once())
            ->method('queryByBroadcastTimeRange')
            ->with($this->beginning, $this->end)
            ->willReturn($this->animes);

        $this->sut->run($this->beginning, $this->end, function ($anime, $timeLeftToBeTransmitted): void {
            Carbon::setTestNowAndTimezone(now());
            $broadcastTime = Carbon::createFromFormat('H:i:s', $anime->broadcast->time);
            $timeLeftToBeTransmittedTest = now()->diffInSeconds($broadcastTime);

            $this->assertEquals($anime, $this->animes->first());
            $this->assertEquals($timeLeftToBeTransmitted, $timeLeftToBeTransmittedTest);
        });
    }

    public function testShouldNotRunARoutineWhenNotFoundAnyAnime(): void
    {
        $animes = new AnimesCollection();

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByBroadcastTimeRange')
            ->with($this->beginning, $this->end)
            ->willReturn($animes);

        $this->sut->run($this->beginning, $this->end, fn (): null => null);
    }
}
