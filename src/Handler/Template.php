<?php

declare(strict_types=1);

namespace FST\Weave\Handler;

use FST\Weave\Engine;
use FST\Weave\Exception\ExpectsDataToBeAnAssocArray;
use FST\Weave\Exception\StackIsEmptyException;
use FST\Weave\Exception\UsageOfAReservedKeyForbiddenException;

use function extract;
use function ob_get_clean;
use function ob_start;

class Template
{
    protected const RESERVED_KEY = 'content';
    public array $sections = [];
    protected ?self $layout = null;
    protected ?string $currentSection = null;

    public function __construct(
        protected Engine $engine,
        protected string $path,
        protected array $data = [],
    ) {
        if ([] !== $data && array_is_list($data)) {
            throw new ExpectsDataToBeAnAssocArray;
        }
    }

    public function layout(string $template, array $data = []): void
    {
        $this->layout = $this->engine->makeTemplate($template, $data);
    }

    public function start(string $name): void
    {
        if (self::RESERVED_KEY === $name) {
            throw new UsageOfAReservedKeyForbiddenException(self::RESERVED_KEY);
        }

        $this->currentSection = $name;
        ob_start();
    }

    public function stop(): void
    {
        if (null === $this->currentSection) {
            throw new StackIsEmptyException;
        }

        $this->sections[$this->currentSection] = ob_get_clean();
        $this->currentSection = null;
    }

    public function render(): string
    {
        $this->engine->pushTemplate($this);

        extract($this->data);

        ob_start();
        require $this->path;
        $content = ob_get_clean();

        $this->engine->popTemplate();

        if (null === $this->layout) {
            return $content;
        }

        $this->layout->sections = $this->sections;
        $this->layout->sections[self::RESERVED_KEY] = $content;

        return $this->layout->render();
    }
}