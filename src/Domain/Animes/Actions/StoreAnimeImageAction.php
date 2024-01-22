<?php

namespace Domain\Animes\Actions;

use Domain\Shared\Medias\Contracts\MediaRepository;
use Domain\Animes\DTOs\ImageData;
use Domain\Shared\Medias\DTOs\Models\MediaModelData;
use Infra\Integration\AnimeApi\DTOs\AnimeData as ApiAnimeData;
use Infra\Storage\Services\StoreMediaService;

class StoreAnimeImageAction
{
    public function __construct(
        private MediaRepository $mediaRepository,
        private StoreMediaService $storeMediaService,
    ) {}

    public function run(ApiAnimeData $apiAnime): MediaModelData
    {
        $filename =  $this->storeMediaService->generateFileNameByTitle($apiAnime->title, $apiAnime->images->jpg->large_image_url);

        $file = $this->storeMediaService->byExternalUrl(
            $apiAnime->images->jpg->large_image_url,
            $filename,
            dir: 'animes'
        );

        return $this->mediaRepository->create(
            ImageData::fromArray([
                'title' => $apiAnime->title,
                'path' => $file->path,
                'mimetype' => $file->mimetype,
                'disk' => 'local'
            ])
        );
    }
}
