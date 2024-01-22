<?php

namespace Infra\Abstracts\Contracts;

interface Collection
{
    public static function fromArray(array $data): self;

    public function toArray();
}
