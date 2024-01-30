<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class UsageOfAReservedKeyForbiddenException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct(sprintf('`%s` is a reserved key.', $key));
    }
}