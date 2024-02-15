<?php

declare(strict_types=1);

namespace Elemix\Contract;

use Stringable;

interface ClassHandlerContract extends Stringable
{
    public function get(): string;

    public function merge(array|string|null $classes): self;
}
