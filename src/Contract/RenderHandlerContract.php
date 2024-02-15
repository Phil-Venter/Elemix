<?php

declare(strict_types=1);

namespace Elemix\Contract;

interface RenderHandlerContract
{
    public function render(string $template, array $data = []): string;
}