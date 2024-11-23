<?php

namespace Infra\Abstracts;

use Infra\Abstracts\Contracts\Collection;
use Infra\Abstracts\Contracts\DataTransferObject as DataTransferObjectContract;
use ReflectionClass;

abstract class DataTransferObject implements DataTransferObjectContract
{
    public function __construct(array $data = [])
    {
        return self::__construct(...$data);
    }

    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }

    public function toArray(): array
    {
        $properties = get_object_vars($this);

        return array_map(fn ($property): mixed => $this->parse($property), $properties);
    }

    private function parse(mixed $property): mixed
    {
        if (! is_object($property)) {
            return $property;
        }

        $isEnum = (new ReflectionClass($property::class))->isEnum();
        if ($isEnum) {
            return $property->value;
        }

        $arrayable = method_exists($property, 'toArray');
        if ($arrayable) {
            if ($property instanceof Collection) {
                $property = $property->toArray();

                return array_map(fn (mixed $item): mixed => $this->parse($item), $property);
            }

            return $property->toArray();
        }

        return $property;
    }
}
