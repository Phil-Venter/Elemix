<?php

declare(strict_types=1);

namespace Elemix\Contract;

interface PathHandlerContract
{
    public function create(string $template): string;
}