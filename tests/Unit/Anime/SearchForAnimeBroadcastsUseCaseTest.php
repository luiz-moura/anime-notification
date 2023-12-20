<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\DTOs\Collections\AnimesCollection as AnimesModelCollection;
use Domain\Animes\UseCases\SearchForAnimeBroadcastsUseCase;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\DTOs\AnimesData;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection as AnimesApiCollection;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimesMapper;
use Tests\Mocks\AnimesApiDataMock;
use Tests\Mocks\AnimesModelDataMock;
use PHPUnit\Framework\TestCase;

class SearchForAnimeBroadcastsUseCaseTest extends TestCase
{
    private $animeApiService;
    private $animeRepository;
    private $searchForAnimeBroadcastsUseCase;
    private AnimesApiCollection $animesApi;
    private AnimesModelCollection $animesModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->animeApiService = $this->createMock(AnimeApiService::class);
        $this->animeRepository = $this->createMock(AnimeRepository::class);

        $this->searchForAnimeBroadcastsUseCase = new SearchForAnimeBroadcastsUseCase(
            $this->animeApiService,
            $this->animeRepository
        );

        $this->animesApi = new AnimesApiCollection([
            AnimesData::fromArray(
                AnimesMapper::fromArray(AnimesApiDataMock::create())
            ),
            AnimesData::fromArray(
                AnimesMapper::fromArray(AnimesApiDataMock::create())
            ),
        ]);

        $this->animesModel = new AnimesModelCollection([
            AnimesModelDataMock::create(['mal_id' => $this->animesApi[0]->mal_id]),
            AnimesModelDataMock::create(['mal_id' => $this->animesApi[1]->mal_id]),
        ]);
    }

    public function test_should_return_all_animes_not_found_in_the_database()
    {
        $day = 'monday';

        $this->animeApiService
            ->expects($this->once())
            ->method('getSchedulesByDay')
            ->with($day)
            ->willReturn($this->animesApi);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with([$this->animesApi[0]->mal_id, $this->animesApi[1]->mal_id])
            ->willReturn(null);

        $result = $this->searchForAnimeBroadcastsUseCase->run($day);

        $this->assertEquals($this->animesApi, $result);
    }

    public function test_should_not_return_any_anime_as_they_are_all_in_the_database()
    {
        $day = 'saturday';

        $this->animeApiService
            ->expects($this->once())
            ->method('getSchedulesByDay')
            ->with($day)
            ->willReturn($this->animesApi);

        $this->animeRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with([$this->animesApi[0]->mal_id, $this->animesApi[1]->mal_id])
            ->willReturn($this->animesModel);

        $result = $this->searchForAnimeBroadcastsUseCase->run($day);

        $this->assertEquals($result, new AnimesApiCollection());
    }
}
