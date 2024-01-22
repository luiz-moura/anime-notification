<?php

namespace Tests\Mocks;

use Domain\Shared\Medias\DTOs\Models\MediaModelData;

class MediaModelDataMock
{
    public static function create(array $extra = []): MediaModelData
    {
        return MediaModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'title' => fake()->title(),
            'path' => fake()->filePath(),
            'mimetype' => fake()->fileExtension(),
            'disk' => 'local',
        ]);
    }
}
