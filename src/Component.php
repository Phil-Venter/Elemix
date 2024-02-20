<?php

declare(strict_types=1);

namespace Elemix;

use Elemix\Contract\ComponentHandlerContract;
use Elemix\Contract\RenderHandlerContract;
use Elemix\Exception\UnboundComponentInstanceException;

class Component
{
    public static (ComponentHandlerContract&RenderHandlerContract)|null $instance = null;

    public static function bind(ComponentHandlerContract&RenderHandlerContract $instance): void
    {
        self::$instance = $instance;
    }

    public static function getInstance(): ComponentHandlerContract&RenderHandlerContract
    {
        if (null === self::$instance) {
            throw new UnboundComponentInstanceException("Cannot call instance before binding it.");
        }

        return self::$instance;
    }
}
