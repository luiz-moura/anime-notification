<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Shared\Medias\Contracts\MediaRepository as MediaRepositoryContract;
use Domain\Shared\Medias\DTOs\MediasData;
use Domain\Shared\Medias\DTOs\Models\MediasModelData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\Image;

class MediaRepository extends Repository implements MediaRepositoryContract
{
    protected $modelClass = Image::class;

    public function create(MediasData $media): MediasModelData
    {
        return MediasModelData::fromModel(
            $this->model->create($media->toArray())->toArray()
        );
    }
}
