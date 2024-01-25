<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class ComponentExpectsDataToBeAnAssocArray extends Exception
{
    public function __construct(string $method)
    {
        parent::__construct(sprintf('Data parameter passed to %s needs to be an empty or associative array.', $method));
    }
}