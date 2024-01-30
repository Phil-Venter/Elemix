<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class EngineNotBoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot use render system before binding engine.');
    }
}