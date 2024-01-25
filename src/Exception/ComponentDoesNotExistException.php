<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class ComponentDoesNotExistException extends Exception
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('Component does not exist or is not readable at `%s`.', $path));
    }
}