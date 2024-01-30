<?php

declare(strict_types=1);

namespace FST\Weave\Handler;

use function array_fill_keys;
use function array_filter;
use function array_is_list;
use function array_keys;
use function array_map;
use function array_merge;
use function explode;
use function filter_var;
use function implode;
use function is_string;
use function sprintf;

class Classify
{
    protected array $classes = [];

    public function __construct(
        array|string|null $classes,
    ) {
        $this->classes = $this->normalise($classes);
    }

    public function __toString(): string
    {
        return sprintf('class="%s"', $this->get());
    }

    protected function filterVar(mixed $class): bool
    {
        return filter_var($class, FILTER_VALIDATE_BOOL);
    }

    public function get(): string
    {
        $classes = array_filter($this->classes, [$this, 'filterVar']);
        return implode(' ', array_keys($classes));
    }

    public function merge(array|string|null $classes): static
    {
        if (empty($classes)) {
            return $this;
        }

        $this->classes = array_merge(
            $this->classes,
            $this->normalise($classes)
        );

        return $this;
    }

    protected function normalise(array|string|null $classes): array
    {
        if (empty($classes)) {
            return [];
        }

        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }

        if (array_is_list($classes)) {
            $classes = array_fill_keys($classes, true);
        }

        return array_map([$this, 'filterVar'], $classes);
    }
}