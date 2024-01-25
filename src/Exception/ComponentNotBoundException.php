<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class ComponentNotBoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot use component system before binding handler.');
    }
}