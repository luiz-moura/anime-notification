<?php

namespace Domain\Shared\Medias\DTOs\Mappers;

class MediasModelMapper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'],
            'title' => $data['title'],
            'path' => $data['path'],
            'mimetype' => $data['mimetype'],
            'disk' => $data['disk'],
        ];
    }
}
