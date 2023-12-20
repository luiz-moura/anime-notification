<?php

namespace Domain\Animes\DTOs;

use DateTime;
use Domain\Animes\DTOs\Collections\AnimeImagesCollection;
use Domain\Animes\DTOs\Collections\AnimeTitlesCollection;
use Domain\Animes\DTOs\Collections\GenresCollection;
use Domain\Animes\DTOs\Mappers\AnimesApiMapper;
use Infra\Abstracts\DataTransferObject;

class AnimesData extends DataTransferObject
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
        public ?AnimeTitlesCollection $titles,
        public ?AnimeImagesCollection $images,
        public ?BroadcastsData $broadcast,
        public ?GenresCollection $genres,
    ) {}

    public static function fromApi(array $data): self
    {
        return self::fromArray(
            AnimesApiMapper::fromArray($data)
        );
    }
}
