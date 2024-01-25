<?php

declare(strict_types=1);

function fw_class(array|string|null $classes): FST\Weave\Handler\ClassHandler
{
    return new FST\Weave\Handler\ClassHandler($classes);
}

function fw_push(string $template, array $data = []): void
{
    FST\Weave\Component::getInstance()->push($template, $data);
}

function fw_pop(): void
{
    FST\Weave\Component::getInstance()->pop();
}

function fw_render(string $template, array $data = []): string
{
    return FST\Weave\Component::getInstance()->render($template, $data);
}