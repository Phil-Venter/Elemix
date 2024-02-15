<?php

declare(strict_types=1);

namespace Elemix\Handler;

use Elemix\Contract\PathHandlerContract;
use Elemix\Contract\RenderHandlerContract;

final class RenderHandler implements RenderHandlerContract
{
    public function __construct(
        private PathHandlerContract $pathHandler,
    ) {
    }

    public function render(string $template, array $data = []): string
    {
        \ob_start();

        (function () use ($template, $data) {
            \extract($data);
            require $this->pathHandler->create($template);
        })();

        return \ob_get_clean();
    }
}