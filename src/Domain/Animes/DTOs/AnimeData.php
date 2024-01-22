<?php

namespace Domain\Animes\DTOs;

use DateTime;
use Domain\Animes\DTOs\Collections\ImagesCollection;
use Domain\Animes\DTOs\Collections\TitlesCollection;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\Mappers\AnimeApiMapper;
use Infra\Abstracts\DataTransferObject;

class AnimeData extends DataTransferObject
{
    public function __construct(
        public int $mal_id,
        public string $mal_url,
        public string $title,
        public string $slug,
        public bool $approved,
        public bool $airing,
        public ?string $type,
        public ?string $source,
        public ?int $episodes,
        public ?string $status,
        public ?string $duration,
        public ?string $rating,
        public ?string $synopsis,
        public ?string $background,
        public ?string $season,
        public ?int $year,
        public ?DateTime $aired_from,
        public ?DateTime $aired_to,
        public ?TitlesCollection $titles,
        public ?ImagesCollection $images,
        public ?BroadcastData $broadcast,
        public ?GenresCollection $genres,
    ) {}

    public static function fromApi(array $data): self
    {
        return self::fromArray(
            AnimeApiMapper::fromArray($data)
        );
    }
}
