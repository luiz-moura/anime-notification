<?php

namespace Domain\Animes\DTOs\Mappers;

class ImagesModelMappper
{
    public static function fromArray(array $data): array
    {
        return [
            'id' => $data['id'] ?? null,
            'title' => $data['title'],
            'path' => $data['path'],
            'mimetype' => $data['mimetype'],
            'disk' => $data['disk'],
        ];
    }
}
