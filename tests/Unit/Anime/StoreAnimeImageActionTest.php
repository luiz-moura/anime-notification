<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\StoreAnimeImageAction;
use Domain\Animes\DTOs\ImageData;
use Domain\Shared\Medias\Contracts\MediaRepository;
use Domain\Shared\Medias\DTOs\Models\MediaModelData;
use Illuminate\Support\Str;
use Infra\Integration\AnimeApi\DTOs\AnimeData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimeMapper;
use Infra\Storage\DTOs\StoredMediaData;
use Infra\Storage\Services\StoreMediaService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeApiDataMock;

class StoreAnimeImageActionTest extends TestCase
{
    private StoreAnimeImageAction $sut;
    private MockObject|MediaRepository $mediaRepository;
    private MockObject|StoreMediaService $storeMediaService;
    private AnimeData $apiAnime;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var MediaRepository */
        $this->mediaRepository = $this->createMock(MediaRepository::class);
        /** @var StoreMediaService */
        $this->storeMediaService = $this->createMock(StoreMediaService::class);

        $this->apiAnime = AnimeData::fromArray(
            AnimeMapper::fromArray(AnimeApiDataMock::create())
        );

        $this->sut = new StoreAnimeImageAction(
            $this->mediaRepository,
            $this->storeMediaService
        );
    }

    public function testShouldStoreTheImageSuccessfully(): void
    {
        $filename = Str::slug($this->apiAnime->title) . '+Xv1KLy.jpg';

        $file = StoredMediaData::fromArray([
            'path' => "animes/{$filename}",
            'filename' => $filename,
            'extension' => '.jpg',
            'mimetype' => 'image/jpg',
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
                    'disk' => 'local',
                ])
            )
            ->willReturn(
                MediaModelData::fromArray([
                    'id' => 1,
                    'title' => $this->apiAnime->title,
                    'path' => $file->path,
                    'mimetype' => 'jpg',
                    'disk' => 'local',
                ])
            );

        $this->sut->run($this->apiAnime);
    }
}
