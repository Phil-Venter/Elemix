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
        $classes = \array_filter($this->classes);

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

        $classes = \array_map(
            fn ($val) => \filter_var($val, FILTER_VALIDATE_BOOL),
            $classes,
        );

        return $this->splitGroupedKeys($classes);
    }

    private function splitGroupedKeys(array $classes): array
    {
        $result = [];

        foreach ($classes as $keys => $val) {
            if (!\str_contains(' ', $keys)) {
                $result[$keys] = $val;

                continue;
            }

            foreach (\explode(' ', $keys) as $key) {
                $result[$key] = $val;
            }
        }

        return $result;
    }
}
