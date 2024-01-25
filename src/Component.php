<?php

declare(strict_types=1);

namespace FST\Weave;

use FST\Weave\Contract\ComponentHandlerContract;
use FST\Weave\Exception\ComponentNotBoundException;

class Component
{
    protected static ?ComponentHandlerContract $instance = null;

    public static function getInstance(): ComponentHandlerContract {
        if (null === self::$instance) {
            throw new ComponentNotBoundException;
        }

        return self::$instance;
    }

    public static function bind(ComponentHandlerContract $instance): void
    {
        self::$instance = $instance;
    }
}