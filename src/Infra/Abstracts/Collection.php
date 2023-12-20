<?php

namespace Infra\Abstracts;

use ArrayAccess;
use Illuminate\Support\Collection as SupportCollection;
use Infra\Abstracts\Contracts\Collection as CollectionContract;

abstract class Collection extends SupportCollection implements ArrayAccess, CollectionContract
{
    protected string $collectionOf;

    public function __construct($items = [])
    {
        parent::__construct($items);
        $this->validateItemTypes();
    }

    public static function fromArray(array $data): self
    {
        return new static($data);
    }

    private function validateItemTypes(): void
    {
        $this->ensure($this->collectionOf);
    }
}
