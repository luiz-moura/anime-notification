<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\CreateAnimeGenresAction;
use Domain\Animes\Contracts\GenreRepository;
use Domain\Animes\DTOs\Collections\GenresCollection as GenresModelCollection;
use Domain\Animes\DTOs\GenresData;
use Domain\Animes\Enums\GenreTypesEnum;
use Infra\Integration\AnimeApi\DTOs\AnimesData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimesMapper;
use Tests\Mocks\AnimesApiDataMock;
use Tests\Mocks\GenresModelDataMock;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;

class CreateAnimeGenresActionTest extends TestCase
{
    private $apiAnime;
    private $genresModel;
    private $createAnimeGenresAction;
    private $genreRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->genreRepository = $this->createMock(GenreRepository::class);

        $this->apiAnime = AnimesData::fromArray(
            AnimesMapper::fromArray(AnimesApiDataMock::create())
        );

        $this->createAnimeGenresAction = new CreateAnimeGenresAction(
            $this->genreRepository
        );
    }

    public function test_should_register_all_genres_that_are_not_in_the_database()
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
                    GenresData::fromArray([
                        'slug' => Str::slug($genre1->name),
                        'name' => $genre1->name,
                        'mal_id' => $genre1->mal_id,
                        'mal_url' => $genre1->url,
                        'type' => GenreTypesEnum::from('common'),
                    ]),
                    GenresData::fromArray([
                        'slug' => Str::slug($genre2->name),
                        'name' => $genre2->name,
                        'mal_id' => $genre2->mal_id,
                        'mal_url' => $genre2->url,
                        'type' => GenreTypesEnum::from('explicit'),
                    ]),
                    GenresData::fromArray([
                        'slug' => Str::slug($genre3->name),
                        'name' => $genre3->name,
                        'mal_id' => $genre3->mal_id,
                        'mal_url' => $genre3->url,
                        'type' => GenreTypesEnum::from('theme'),
                    ]),
                    GenresData::fromArray([
                        'slug' => Str::slug($genre4->name),
                        'name' => $genre4->name,
                        'mal_id' => $genre4->mal_id,
                        'mal_url' => $genre4->url,
                        'type' => GenreTypesEnum::from('demographic'),
                    ]),
                )
            );

        $this->createAnimeGenresAction->run($this->apiAnime);
    }

    public function test_should_not_register_genres_that_are_already_in_the_database()
    {
        $this->genresModel = new GenresModelCollection([
            GenresModelDataMock::create(['mal_id' => $this->apiAnime->genres[0]->mal_id]),
            GenresModelDataMock::create(['mal_id' => $this->apiAnime->explicit_genres[0]->mal_id]),
            GenresModelDataMock::create(['mal_id' => $this->apiAnime->demographics[0]->mal_id]),
            GenresModelDataMock::create(['mal_id' => $this->apiAnime->themes[0]->mal_id]),
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

        $this->createAnimeGenresAction->run($this->apiAnime);
    }
}
