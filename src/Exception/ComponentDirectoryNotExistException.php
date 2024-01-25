<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class ComponentDirectoryNotExistException extends Exception
{
    public function __construct(string $directory)
    {
        parent::__construct(sprintf('Directory does not exist or is not readable at `%s`.', $directory));
    }
}