<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class ComponentStackIsEmptyException extends Exception
{
    public function __construct()
    {
        parent::__construct('You cannot stop a component, as there are none open.');
    }
}