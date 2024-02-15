<?php

declare(strict_types=1);

namespace Elemix;

use Elemix\Contract\ClassHandlerContract;
use Elemix\Contract\ComponentHandlerContract;
use Elemix\Contract\RenderHandlerContract;
use Elemix\Exception\UnboundComponentInstanceException;
use Elemix\Handler\ClassHandler;

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

    public static function classify(array|string|null $classes): ClassHandlerContract
    {
        return new ClassHandler($classes);
    }

    public static function start(string $template, array $data = []): void
    {
        self::getInstance()->start($template, $data);
    }

    public static function end(): string
    {
        return self::getInstance()->end();
    }

    public static function render(string $template, array $data = []): string
    {
        return self::getInstance()->render($template, $data);
    }
}