<?php

declare(strict_types=1);

namespace FST\Weave\Handler;

class ClassHandler
{
    protected array $classes = [];

    public function __construct(array|string|null $classes)
    {
        $this->classes = $this->normalise($classes);
    }

    public function attr(): string
    {
        return sprintf('class="%s"', $this->get());
    }

    public function merge(array|string|null $classes): static
    {
        $this->classes = array_merge(
            $this->classes,
            $this->normalise($classes)
        );

        return $this;
    }

    public function get(): string
    {
        $classes = array_filter($this->classes, [$this, 'filterVar']);
        return implode(' ', array_keys($classes));
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

    protected function filterVar(mixed $class): bool
    {
        return filter_var($class, FILTER_VALIDATE_BOOL);
    }
}