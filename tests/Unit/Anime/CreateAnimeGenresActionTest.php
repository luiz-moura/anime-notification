<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\CreateAnimeGenresAction;
use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\DTOs\Collections\GenresCollection as GenresModelCollection;
use Domain\Animes\DTOs\GenreData;
use Domain\Animes\Enums\GenreTypesEnum;
use Illuminate\Support\Str;
use Infra\Integration\AnimeApi\DTOs\AnimeData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimeMapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeApiDataMock;
use Tests\Mocks\GenreModelDataMock;

class CreateAnimeGenresActionTest extends TestCase
{
    private CreateAnimeGenresAction $sut;
    private GenreRepository|MockObject $genreRepository;
    private AnimeData $apiAnime;
    private GenresModelCollection $genresModel;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var GenreRepository */
        $this->genreRepository = $this->createMock(GenreRepository::class);

        $this->apiAnime = AnimeData::fromArray(
            AnimeMapper::fromArray(AnimeApiDataMock::create())
        );

        $this->sut = new CreateAnimeGenresAction(
            $this->genreRepository
        );
    }

    public function testShouldRegisterAllGenresThatAreNotInTheDatabase(): void
    {
        $this->genreRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with([
                $this->apiAnime->genres[0]->mal_id,
                $this->apiAnime->explicit_genres[0]->mal_id,
                $this->apiAnime->themes[0]->mal_id,
                $this->apiAnime->demographics[0]->mal_id,
            ])
            ->willReturn(new GenresModelCollection());

        $genre1 = $this->apiAnime->genres[0];
        $genre2 = $this->apiAnime->explicit_genres[0];
        $genre3 = $this->apiAnime->themes[0];
        $genre4 = $this->apiAnime->demographics[0];

        $this->genreRepository
            ->expects($this->exactly(4))
            ->method('create')
            ->with(
                $this->logicalOr(
                    GenreData::fromArray([
                        'slug' => Str::slug($genre1->name),
                        'name' => $genre1->name,
                        'mal_id' => $genre1->mal_id,
                        'mal_url' => $genre1->url,
                        'type' => GenreTypesEnum::from('common'),
                    ]),
                    GenreData::fromArray([
                        'slug' => Str::slug($genre2->name),
                        'name' => $genre2->name,
                        'mal_id' => $genre2->mal_id,
                        'mal_url' => $genre2->url,
                        'type' => GenreTypesEnum::from('explicit'),
                    ]),
                    GenreData::fromArray([
                        'slug' => Str::slug($genre3->name),
                        'name' => $genre3->name,
                        'mal_id' => $genre3->mal_id,
                        'mal_url' => $genre3->url,
                        'type' => GenreTypesEnum::from('theme'),
                    ]),
                    GenreData::fromArray([
                        'slug' => Str::slug($genre4->name),
                        'name' => $genre4->name,
                        'mal_id' => $genre4->mal_id,
                        'mal_url' => $genre4->url,
                        'type' => GenreTypesEnum::from('demographic'),
                    ]),
                )
            );

        $this->sut->run($this->apiAnime);
    }

    public function testShouldNotRegisterGenresThatAreAlreadyInTheDatabase(): void
    {
        $this->genresModel = new GenresModelCollection([
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->genres[0]->mal_id]),
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->explicit_genres[0]->mal_id]),
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->demographics[0]->mal_id]),
            GenreModelDataMock::create(['mal_id' => $this->apiAnime->themes[0]->mal_id]),
        ]);

        $this->genreRepository
            ->expects($this->once())
            ->method('queryByMalIds')
            ->with([
                $this->apiAnime->genres[0]->mal_id,
                $this->apiAnime->explicit_genres[0]->mal_id,
                $this->apiAnime->themes[0]->mal_id,
                $this->apiAnime->demographics[0]->mal_id,
            ])
            ->willReturn($this->genresModel);

        $this->genreRepository
            ->expects($this->never())
            ->method('create');

        $this->sut->run($this->apiAnime);
    }
}
