<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\StoreAnimeImageAction;
use Domain\Animes\DTOs\ImageData;
use Domain\Shared\Medias\Contracts\MediaRepository;
use Domain\Shared\Medias\DTOs\Models\MediaModelData;
use Infra\Integration\AnimeApi\DTOs\AnimeData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimeMapper;
use Tests\Mocks\AnimeApiDataMock;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;
use Infra\Storage\DTOs\StoredMediaData;
use Infra\Storage\Services\StoreMediaService;

class StoreAnimeImageActionTest extends TestCase
{
    private $apiAnime;
    private $storeAnimeImageAction;
    private $mediaRepository;
    private $storeMediaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mediaRepository = $this->createMock(MediaRepository::class);
        $this->storeMediaService = $this->createMock(StoreMediaService::class);

        $this->apiAnime = AnimeData::fromArray(
            AnimeMapper::fromArray(AnimeApiDataMock::create())
        );

        $this->storeAnimeImageAction = new StoreAnimeImageAction(
            $this->mediaRepository,
            $this->storeMediaService
        );
    }

    public function test_should_store_the_image_successfully()
    {
        $filename = Str::slug($this->apiAnime->title) . '+' . 'Xv1KLy' . '.jpg';

        $file = StoredMediaData::fromArray([
            'path' => "animes/{$filename}",
            'filename' => $filename,
            'extension' => 'dasdas',
            'mimetype' => 'jpg'
        ]);

        $this->storeMediaService
            ->expects($this->once())
            ->method('generateFileNameByTitle')
            ->with($this->apiAnime->title, $this->apiAnime->images->jpg->large_image_url)
            ->willReturn($filename);

        $this->storeMediaService
            ->expects($this->once())
            ->method('byExternalUrl')
            ->with($this->apiAnime->images->jpg->large_image_url, $filename, 'animes')
            ->willReturn($file);

        $this->mediaRepository
            ->expects($this->once())
            ->method('create')
            ->with(
                ImageData::fromArray([
                    'title' => $this->apiAnime->title,
                    'path' => $file->path,
                    'mimetype' => $file->mimetype,
                    'disk' => 'local'
                ])
            )
            ->willReturn(
                MediaModelData::fromArray([
                    'id' => 1,
                    'title' => $this->apiAnime->title,
                    'path' => $file->path,
                    'mimetype' => 'jpg',
                    'disk' => 'local'
                ])
            );

        $this->storeAnimeImageAction->run($this->apiAnime);
    }
}
