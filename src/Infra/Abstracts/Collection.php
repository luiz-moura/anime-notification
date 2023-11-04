<?php

namespace Infra\Abstracts;

use ArrayAccess;
use Illuminate\Support\Collection as SupportCollection;
use Infra\Abstracts\Contracts\Collection as CollectionContract;

abstract class Collection extends SupportCollection implements ArrayAccess, CollectionContract
{
    public static function fromArray(array $data): self
    {
        return new static($data);
    }
}
