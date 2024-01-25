<?php

declare(strict_types=1);

use FST\Weave\Handler\ClassHandler;
use FST\Weave\Component;

function fw_class(array|string|null $classes): ClassHandler
{
    return new ClassHandler($classes);
}

function fw_fetch(string $template, array $data = []): string
{
    return Component::getInstance()->render($template, $data);
}

function fw_pop(): void
{
    Component::getInstance()->pop();
}

function fw_push(string $template, array $data = []): void
{
    Component::getInstance()->push($template, $data);
}

function fw_render(string $template, array $data = []): void
{
    echo Component::getInstance()->render($template, $data);
}