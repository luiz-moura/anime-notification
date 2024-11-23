<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\CreateAnimeGenresAction;
use Domain\Animes\Actions\StoreAnimeImageAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeTitleRepository;
use Domain\Animes\Contracts\BroadcastRepository;
use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\DTOs\AnimeData;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\Mappers\AnimeModelMapper;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Domain\Animes\UseCases\CreateAnimeUseCase;
use Domain\Shared\Medias\Contracts\MediaRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimeMapper;
use Infra\Storage\Services\StoreMediaService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeApiDataMock;
use Tests\Mocks\BroadcastModelDataMock;
use Tests\Mocks\GenreModelDataMock;
use Tests\Mocks\MediaModelDataMock;

class CreateAnimeUseCaseTest extends TestCase
{
    private CreateAnimeUseCase $sut;
    private MockObject|GenreRepository $genreRepository;
    private MockObject|AnimeRepository $animeRepository;
    private MockObject|MediaRepository $mediaRepository;
    private MockObject|BroadcastRepository $broadcastRepository;
    private MockObject|AnimeTitleRepository $animeTitleRepository;
    private MockObject|StoreMediaService $storeMediaService;
    private MockObject|CreateAnimeGenresAction $createAnimeGenresAction;
    private MockObject|StoreAnimeImageAction $storeAnimeImageAction;
    private ApiAnimeData $apiAnime;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GenreRepository */
        $this->genreRepository = $this->createMock(GenreRepository::class);
        /** @var AnimeRepository */
        $this->animeRepository = $this->createMock(AnimeRepository::class);
        /** @var MediaRepository */
        $this->mediaRepository = $this->createMock(MediaRepository::class);
        /** @var BroadcastRepository */
        $this->broadcastRepository = $this->createMock(BroadcastRepository::class);
        /** @var AnimeTitleRepository */
        $this->animeTitleRepository = $this->createMock(AnimeTitleRepository::class);
        /** @var StoreMediaService */
        $this->storeMediaService = $this->createMock(StoreMediaService::class);
        /** @var CreateAnimeGenresAction */
        $this->createAnimeGenresAction = $this->createMock(CreateAnimeGenresAction::class);
        /** @var StoreAnimeImageAction */
        $this->storeAnimeImageAction = $this->createMock(StoreAnimeImageAction::class);

        $this->apiAnime = ApiAnimeData::fromArray(
            AnimeMapper::fromArray(AnimeApiDataMock::create())
        );

        $this->sut = new CreateAnimeUseCase(
            $this->genreRepository,
            $this->animeRepository,
            $this->mediaRepository,
            $this->broadcastRepository,
            $this->animeTitleRepository,
            $this->storeMediaService,
            $this->createAnimeGenresAction,
            $this->storeAnimeImageAction,
        );
    }

    public function testShouldRegisterTheAnimeSuccessfully(): void
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(fn ($callback): mixed => $callback());

        $animeRaw = AnimeData::fromApi($this->apiAnime->toArray());
        $animeModel = AnimeModelData::fromArray(
            AnimeModelMapper::fromArray(
                Arr::except($animeRaw->toArray(), ['titles', 'images', 'broadcast', 'genres']) + ['id' => 1]
            )
        );
        $animeImage = MediaModelDataMock::create();
        $animeGenres = new GenresCollection([
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->genres[0]->mal_id]),
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->explicit_genres[0]->mal_id]),
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->demographics[0]->mal_id]),
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->themes[0]->mal_id]),
        ]);

        $this->createAnimeGenresAction
            ->expects($this->once())
            ->method('run')
            ->with($this->apiAnime);

        $this->animeRepository
            ->expects($this->once())
            ->method('create')
            ->with($animeRaw)
            ->willReturn($animeModel);

        $this->broadcastRepository
            ->expects($this->once())
            ->method('create')
            ->with($animeModel->id, $animeRaw->broadcast)
            ->willReturn(BroadcastModelDataMock::create());

        $this->animeTitleRepository
            ->expects($this->once())
            ->method('create')
            ->with($animeModel->id, $animeRaw->titles[0]);

        $this->storeAnimeImageAction
            ->expects($this->once())
            ->method('run')
            ->with($this->apiAnime)
            ->willReturn($animeImage);

        $this->animeRepository
            ->expects($this->once())
            ->method('attachImages')
            ->with($animeModel->id, $animeImage->id);

        $this->genreRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with([$this->apiAnime->genres[0]->mal_id, $this->apiAnime->explicit_genres[0]->mal_id, $this->apiAnime->themes[0]->mal_id, $this->apiAnime->demographics[0]->mal_id])
            ->willReturn($animeGenres);

        $this->animeRepository
            ->expects($this->once())
            ->method('attachGenres')
            ->with($animeModel->id, array_values(array_column($animeGenres->all(), 'id')));

        $this->sut->run($this->apiAnime);
    }
}
