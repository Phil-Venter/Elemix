<?php

declare(strict_types=1);

namespace Elemix\Contract;

interface ComponentHandlerContract
{
    public function start(string $template, array $data = []): void;

    public function end(): string;
}