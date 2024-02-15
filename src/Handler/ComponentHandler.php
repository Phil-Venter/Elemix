<?php

declare(strict_types=1);

namespace Elemix\Handler;

use Elemix\Contract\ComponentHandlerContract;
use Elemix\Contract\RenderHandlerContract;

final class ComponentHandler implements ComponentHandlerContract, RenderHandlerContract
{
    private const KEY = 'slot';

    private \SplStack $stack;

    public function __construct(
        private RenderHandlerContract $renderHandler,
    ) {
        $this->stack = new \SplStack;
    }

    public function start(string $template, array $data = []): void
    {
        $this->stack->push([$template, $data]);
        \ob_start();
    }

    public function end(): string
    {
        [$template, $data] = $this->stack->pop();
        $data[self::KEY] = \ob_get_clean();
        return $this->render($template, $data);
    }

    public function render(string $template, array $data = []): string
    {
        return $this->renderHandler->render($template, $data);
    }
}