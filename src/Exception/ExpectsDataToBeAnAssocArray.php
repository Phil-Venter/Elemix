<?php

declare(strict_types=1);

namespace FST\Weave\Exception;

use Exception;

class ExpectsDataToBeAnAssocArray extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf('Data parameter passed needs to be an empty or associative array.'));
    }
}