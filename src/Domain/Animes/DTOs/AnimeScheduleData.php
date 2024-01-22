<?php

namespace Domain\Animes\DTOs;

use Domain\Animes\DTOs\Collections\AnimesCollection;
use Domain\Animes\DTOs\Mappers\AnimeScheduleMapper;
use Infra\Abstracts\DataTransferObject;

class AnimeScheduleData extends DataTransferObject
{
    public function __construct(
        public AnimesCollection $mondays,
        public AnimesCollection $tuesdays,
        public AnimesCollection $wednesdays,
        public AnimesCollection $thursdays,
        public AnimesCollection $fridays,
        public AnimesCollection $saturdays,
        public AnimesCollection $sundays,
        public AnimesCollection $unknown,
    ) {}

    public static function fromAnimesCollection(AnimesCollection $data): self
    {
        return new self(...AnimeScheduleMapper::fromAnimesCollection($data));
    }
}
