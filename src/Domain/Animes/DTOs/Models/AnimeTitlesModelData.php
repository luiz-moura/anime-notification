<?php

namespace Domain\Animes\DTOs\Models;

use Domain\Animes\DTOs\AnimeTitlesData;

class AnimeTitlesModelData extends AnimeTitlesData
{
    public function __construct(public int $id, ...$args)
    {
        parent::__construct(...$args);
    }
}
