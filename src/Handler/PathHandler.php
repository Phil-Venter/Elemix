<?php

declare(strict_types=1);

namespace Elemix\Handler;

use Elemix\Contract\PathHandlerContract;

final class PathHandler implements PathHandlerContract
{
    private array $directories = [];

    public function __construct(
        private string $directory,
        private string $extension,
    ) {
        $this->directory = $this->clean($directory);
    }

    public function add(string $key, string $directory): self
    {
        $this->directories[$key] = $this->clean($directory);
        return $this;
    }

    public function create(string $template): string
    {
        $directory = $this->directory;
        $template = \rtrim(\preg_replace(['/\.+/', '/\/+/'], ['', '/'], $template), '/');

        if (\str_contains($template, '::')) {
            [$key, $template] = \explode('::', $template);
            $directory = $this->directories[$key];
        }

        return "{$directory}/{$template}.{$this->extension}";
    }

    private function clean(string $directory): string
    {
        return \rtrim(\preg_replace('/\/+/', '/', $directory), '/');
    }
}