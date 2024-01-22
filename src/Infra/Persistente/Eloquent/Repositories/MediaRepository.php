<?php

namespace Infra\Persistente\Eloquent\Repositories;

use Domain\Shared\Medias\Contracts\MediaRepository as MediaRepositoryContract;
use Domain\Shared\Medias\DTOs\MediaData;
use Domain\Shared\Medias\DTOs\Models\MediaModelData;
use Infra\Abstracts\Repository;
use Infra\Persistente\Eloquent\Models\Image;

class MediaRepository extends Repository implements MediaRepositoryContract
{
    protected $modelClass = Image::class;

    public function create(MediaData $media): MediaModelData
    {
        return MediaModelData::fromModel(
            $this->model->create($media->toArray())->toArray()
        );
    }
}
