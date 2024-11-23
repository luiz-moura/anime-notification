<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\Collections\AnimesCollection as AnimesModelCollection;
use Domain\Animes\UseCases\ImportAnimesFromApiUseCase;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\DTOs\AnimeData;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection as ApiAnimesCollection;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimeMapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeApiDataMock;
use Tests\Mocks\AnimeModelDataMock;

class ImportAnimesFromApiUseCaseTest extends TestCase
{
    private ImportAnimesFromApiUseCase $sut;
    private MockObject|AnimeApiService $animeApiService;
    private MockObject|AnimeRepository $animeRepository;
    private ApiAnimesCollection $animesApi;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var AnimeApiService */
        $this->animeApiService = $this->createMock(AnimeApiService::class);
        /** @var AnimeRepository */
        $this->animeRepository = $this->createMock(AnimeRepository::class);

        $this->sut = new ImportAnimesFromApiUseCase(
            $this->animeApiService,
            $this->animeRepository
        );

        $this->animesApi = new ApiAnimesCollection([
            AnimeData::fromArray(
                AnimeMapper::fromArray(AnimeApiDataMock::create())
            ),
            AnimeData::fromArray(
                AnimeMapper::fromArray(AnimeApiDataMock::create())
            ),
            AnimeData::fromArray(
                AnimeMapper::fromArray(AnimeApiDataMock::create())
            ),
            AnimeData::fromArray(
                AnimeMapper::fromArray(AnimeApiDataMock::create())
            ),
        ]);
    }

    public function testShouldReturnUnregisteredAnimesAndThoseThatLeftTheSchedule(): void
    {
        $day = 'monday';

        $animesAlreadyRegistered = new AnimesModelCollection([
            AnimeModelDataMock::create(['mal_id' => $this->animesApi[0]->mal_id, 'airing' => false]),
            AnimeModelDataMock::create(['mal_id' => $this->animesApi[1]->mal_id, 'airing' => false]),
        ]);

        $animesThatLeftSchedule = new AnimesModelCollection([
            AnimeModelDataMock::create(['airing' => true]),
            AnimeModelDataMock::create(['airing' => true]),
        ]);

        $this->animeApiService
            ->expects($this->once())
            ->method('getSchedulesByDay')
            ->with($day)
            ->willReturn($this->animesApi);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with(collect($this->animesApi)->pluck('mal_id')->all())
            ->willReturn($animesAlreadyRegistered);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryAiringByDayExceptMalIds')
            ->with("{$day}s", collect($this->animesApi)->pluck('mal_id')->all())
            ->willReturn($animesThatLeftSchedule);

        $this->sut->run(
            $day,
            fn (): string => 'do-something',
            fn (): string => 'do-something',
        );
    }

    public function testShouldNotFindAnyAnimeToBeRegisteredOrThatHaveBeenLeftOnTheSchedule(): void
    {
        $day = 'saturday';

        $animesAlreadyRegistered = new AnimesModelCollection([
            AnimeModelDataMock::create(['mal_id' => $this->animesApi[0]->mal_id, 'airing' => true]),
            AnimeModelDataMock::create(['mal_id' => $this->animesApi[1]->mal_id, 'airing' => true]),
            AnimeModelDataMock::create(['mal_id' => $this->animesApi[2]->mal_id, 'airing' => true]),
            AnimeModelDataMock::create(['mal_id' => $this->animesApi[3]->mal_id, 'airing' => true]),
        ]);

        $animesThatLeftSchedule = new AnimesModelCollection();

        $this->animeApiService
            ->expects($this->once())
            ->method('getSchedulesByDay')
            ->with($day)
            ->willReturn($this->animesApi);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with(collect($this->animesApi)->pluck('mal_id')->all())
            ->willReturn($animesAlreadyRegistered);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryAiringByDayExceptMalIds')
            ->with("{$day}s", collect($this->animesApi)->pluck('mal_id')->all())
            ->willReturn($animesThatLeftSchedule);

        $this->sut->run(
            $day,
            fn (): string => 'do-something',
            fn (): string => 'do-something',
        );
    }
}
