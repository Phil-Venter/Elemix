<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class StackIsEmptyException extends Exception
{
    public function __construct()
    {
        parent::__construct('You cannot stop component/section, as there are none open.');
    }
}