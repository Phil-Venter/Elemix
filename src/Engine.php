<?php

declare(strict_types=1);

namespace FST\Weave;

use FST\Weave\Exception\DirectoryDoesNotExistException;
use FST\Weave\Exception\StackIsEmptyException;
use FST\Weave\Handler\Component;
use FST\Weave\Handler\Template;

use function array_pop;
use function array_push;
use function explode;
use function is_dir;
use function rtrim;
use function sprintf;

class Engine
{
    protected Component $component;
    protected array $templateStack = [];
    protected array $directories = [];

    public function __construct(
        protected ?string $directory = null,
        protected string $extension = 'tmpl.php',
    ) {
        $this->component = new Component($this);

        if (null !== $directory) {
            $this->directory = $this->cleanDirectoryPath($directory);
        }
    }

    public function getComponent(): Component
    {
        return $this->component;
    }

    public function makeTemplate(string $template, array $data = []): Template
    {
        return new Template($this, $this->makePath($template), $data);
    }

    public function pushTemplate(Template $template): void
    {
        array_push($this->templateStack, $template);
    }

    public function popTemplate(): Template
    {
        return array_pop($this->templateStack);
    }

    public function getTemplate(): Template
    {
        if ([] === $this->templateStack) {
            throw new StackIsEmptyException;
        }

        return end($this->templateStack);
    }

    protected function makePath(string $template): string
    {
        $directory = $this->directory ?? null;
        $file = $template;

        if (str_contains($template, '::')) {
            [$dir, $file] = explode('::', $template);
            $directory = $this->directories[$dir] ?? $directory;
        }

        if (null === $directory) {
            throw new DirectoryDoesNotExistException('?');
        }

        return sprintf('%s/%s.%s', $directory, $file, $this->extension);
    }


    public function addDirectory(string $key, string $directory): static
    {
        $this->directories[$key] = $this->cleanDirectoryPath($directory);
        return $this;
    }

    protected function cleanDirectoryPath(string $directory): string
    {
        if (!is_dir($directory)) {
            throw new DirectoryDoesNotExistException($directory);
        }

        return rtrim($directory, '/');
    }
}