<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\StoreAnimeImageAction;
use Domain\Animes\DTOs\ImagesData;
use Domain\Shared\Medias\Contracts\MediaRepository;
use Domain\Shared\Medias\DTOs\Models\MediasModelData;
use Infra\Integration\AnimeApi\DTOs\AnimesData;
use Infra\Integration\AnimeApi\DTOs\Mappers\AnimesMapper;
use Tests\Mocks\AnimesApiDataMock;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Str;
use Infra\Storage\DTOs\MediaData;
use Infra\Storage\Services\StoreMediaService;

class StoreAnimeImageActionTest extends TestCase
{
    private $animeApi;
    private $storeAnimeImageAction;
    private $mediaRepository;
    private $storeMediaService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mediaRepository = $this->createMock(MediaRepository::class);
        $this->storeMediaService = $this->createMock(StoreMediaService::class);

        $this->animeApi = AnimesData::fromArray(
            AnimesMapper::fromArray(AnimesApiDataMock::create())
        );

        $this->storeAnimeImageAction = new StoreAnimeImageAction(
            $this->mediaRepository,
            $this->storeMediaService
        );
    }

    public function test_should_store_the_image_successfully()
    {
        $filename = Str::slug($this->animeApi->title) . '+' . 'Xv1KLy' . '.jpg';

        $file = MediaData::fromArray([
            'path' => "animes/{$filename}",
            'filename' => $filename,
            'extension' => 'dasdas',
            'mimetype' => 'jpg'
        ]);

        $this->storeMediaService
            ->expects($this->once())
            ->method('generateFileNameByTitle')
            ->with($this->animeApi->title, $this->animeApi->images->jpg->large_image_url)
            ->willReturn($filename);

        $this->storeMediaService
            ->expects($this->once())
            ->method('byExternalUrl')
            ->with($this->animeApi->images->jpg->large_image_url, $filename, 'animes')
            ->willReturn($file);

        $this->mediaRepository
            ->expects($this->once())
            ->method('create')
            ->with(
                ImagesData::fromArray([
                    'title' => $this->animeApi->title,
                    'path'=> $file->path,
                    'mimetype' => $file->mimetype,
                    'disk' => 'local'
                ])
            )
            ->willReturn(
                MediasModelData::fromArray([
                    'id' => 1,
                    'title' => $this->animeApi->title,
                    'path' => $file->path,
                    'mimetype' => 'jpg',
                    'disk' => 'local'
                ])
            );

        $this->storeAnimeImageAction->run($this->animeApi);
    }
}
