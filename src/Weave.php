<?php

declare(strict_types=1);

namespace FST\Weave;

use FST\Weave\Exception\EngineNotBoundException;

class Weave
{
    protected static ?Engine $instance = null;

    public static function getInstance(): Engine
    {
        if (null === self::$instance) {
            throw new EngineNotBoundException;
        }

        return self::$instance;
    }

    public static function bind(Engine $engine): void
    {
        self::$instance = $engine;
    }
}