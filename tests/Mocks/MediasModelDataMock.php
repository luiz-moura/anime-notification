<?php

namespace Tests\Mocks;

use Domain\Shared\Medias\DTOs\Models\MediasModelData;

class MediasModelDataMock
{
    public static function create(array $extra = []): MediasModelData
    {
        return MediasModelData::fromArray($extra + [
            'id' => fake()->randomNumber(),
            'title' => fake()->title(),
            'path' => fake()->filePath(),
            'mimetype' => fake()->fileExtension(),
            'disk' => 'local',
        ]);
    }
}
