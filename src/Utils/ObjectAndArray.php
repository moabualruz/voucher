<?php
declare(strict_types=1);

namespace Voucher\Utils;

use ReflectionClass;
use function array_key_exists;
use function get_class;

trait ObjectAndArray
{
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($this);
            $property->setAccessible(false);
        }
        return $array;
    }

    public function fromArray(array $vars): static
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if (array_key_exists($property->getName(), $vars)) {
                $property->setValue($this, $vars[$property->getName()]);
            }
            $property->setAccessible(false);
        }
        return $this;
    }
}