<?php

declare(strict_types=1);

namespace Elemix\Handler;

use Elemix\Contract\ClassHandlerContract;

final class ClassHandler implements ClassHandlerContract
{
    private array $classes = [];

    public function __construct(
        array|string|null $classes,
    ) {
        $this->classes = $this->normalise($classes);
    }

    public function __toString(): string
    {
        return $this->get();
    }

    public function get(): string
    {
        $classes = \array_filter($this->classes, [$this, 'filterValue']);

        return \implode(' ', \array_keys($classes));
    }

    public function merge(array|string|null $classes): self
    {
        if (empty($classes)) {
            return $this;
        }

        $classes = $this->normalise($classes);

        if (empty($classes)) {
            return $this;
        }

        $this->classes = \array_merge($this->classes, $classes);

        return $this;
    }

    private function normalise(array|string|null $classes): array
    {
        if (empty($classes)) {
            return [];
        }

        if (\is_string($classes)) {
            $classes = \explode(' ', $classes);
        }

        if (array_is_list($classes)) {
            $classes = \array_fill_keys(\array_filter($classes), true);
        }

        $classes = \array_map([$this, 'filterValue'], $classes);

        return $this->splitGroupedKeys($classes);
    }

    private function filterValue(mixed $active): bool
    {
        return \filter_var($active, FILTER_VALIDATE_BOOL);
    }

    private function splitGroupedKeys(array $classes): array
    {
        $result = [];

        foreach ($classes as $keys => $val) {
            foreach (\explode(' ', $keys) as $key) {
                $result[$key] = $val;
            }
        }

        return $result;
    }
}
