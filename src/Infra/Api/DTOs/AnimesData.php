<?php

namespace Infra\Api\DTOs;

use Infra\Abstracts\DataTransferObject;
use Infra\Api\DTOs\Collections\MalCollection;
use Infra\Api\DTOs\Collections\TitlesCollection;
use Infra\Api\DTOs\Mappers\AnimesMapper;

class AnimesData extends DataTransferObject
{
    public function __construct(
        public int $mal_id,
        public string $url,
        public string $title,
        public bool $approved,
        public bool $airing,
        public ?string $type,
        public ?string $source,
        public ?int $episodes,
        public ?string $status,
        public ?string $duration,
        public ?string $rating,
        public ?float $score,
        public ?int $scored_by,
        public ?int $rank,
        public ?int $popularity,
        public ?int $members,
        public ?int $favorites,
        public ?string $synopsis,
        public ?string $background,
        public ?string $season,
        public ?int $year,
        public TitlesCollection $titles,
        public AnimeImagesData $images,
        public ?AiredData $aired,
        public ?TrailersData $trailer,
        public ?BroadcastsData $broadcast,
        public ?MalCollection $producers,
        public ?MalCollection $licensors,
        public ?MalCollection $studios,
        public ?MalCollection $genres,
        public ?MalCollection $explicit_genres,
        public ?MalCollection $themes,
        public ?MalCollection $demographics,
    ) {}

    public static function fromApi(array $data)
    {
        return static::withoutMagicalCreationFrom(
            AnimesMapper::fromArray($data)
        );
    }
}
