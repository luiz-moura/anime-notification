<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\CreateAnimeGenresAction;
use Domain\Animes\Actions\StoreAnimeImageAction;
use Domain\Animes\Contracts\AnimeRepository;
use Domain\Animes\Contracts\AnimeTitleRepository;
use Domain\Animes\Contracts\BroadcastRepository;
use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\UseCases\CreateAnimeUseCase;
use Domain\Shared\Medias\Contracts\MediaRepository;
use Domain\Animes\DTOs\AnimeData;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\Mappers\AnimeModelMapper;
use Domain\Animes\DTOs\Models\AnimeModelData;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\BroadcastModelDataMock;
use Tests\Mocks\GenreModelDataMock;
use Tests\Mocks\MediaModelDataMock;
use Tests\Mocks\AnimeApiDataMock;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimeMapper;
use Infra\Storage\Services\StoreMediaService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateAnimeUseCaseTest extends TestCase
{
    private $apiAnime;
    private $genreRepository;
    private $animeRepository;
    private $mediaRepository;
    private $broadcastRepository;
    private $animeTitleRepository;
    private $storeMediaService;
    private $createAnimeGenresAction;
    private $storeAnimeImageAction;
    private $createAnimeUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->genreRepository = $this->createMock(GenreRepository::class);
        $this->animeRepository = $this->createMock(AnimeRepository::class);
        $this->mediaRepository = $this->createMock(MediaRepository::class);
        $this->broadcastRepository = $this->createMock(BroadcastRepository::class);
        $this->animeTitleRepository = $this->createMock(AnimeTitleRepository::class);
        $this->storeMediaService = $this->createMock(StoreMediaService::class);
        $this->createAnimeGenresAction = $this->createMock(CreateAnimeGenresAction::class);
        $this->storeAnimeImageAction = $this->createMock(StoreAnimeImageAction::class);

        $this->apiAnime = ApiAnimeData::fromArray(
            AnimeMapper::fromArray(AnimeApiDataMock::create())
        );

        $this->createAnimeUseCase = new CreateAnimeUseCase(
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

    public function test_should_register_the_anime_successfully()
    {
        DB::shouldReceive('transaction')->once()->andReturnUsing(fn($callback) => $callback());

        $animeRaw = AnimeData::fromApi($this->apiAnime->toArray());
        $animeModel = AnimeModelData::fromArray(
            AnimeModelMapper::fromArray(
                Arr::except($animeRaw->toArray(), ['titles', 'images', 'broadcast', 'genres'])  + ['id' => 1]
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

        $this->createAnimeUseCase->run($this->apiAnime);
    }
}
