<?php

namespace Infra\Storage\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Infra\Storage\DTOs\StoredMediaData;
use Infra\Storage\Exceptions\FailFetchImageException;
use Throwable;

class StoreMediaService
{
    public function byExternalUrl(string $url, string $filename, string $dir): StoredMediaData
    {
        $path = "{$dir}/{$filename}";

        try {
            $file = file_get_contents($url);
        } catch (Throwable $ex) {
            throw new FailFetchImageException($ex);
        }

        Storage::put($path, $file);

        return StoredMediaData::fromArray([
            'path' => $path,
            'filename' => $filename,
            'extension' => mb_strrchr($filename, '.'),
            'mimetype' => Storage::mimeType($path),
        ]);
    }

    public function generateFileNameByTitle(string $title, string $filePath, bool $randomString = true): string
    {
        return Str::slug($title) . '-' . ($randomString ? Str::random(6) : '') . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
    }
}
