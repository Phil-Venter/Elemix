<?php

function classify(
    array|string|null $classes
): Elemix\Contract\ClassHandlerContract {
    return new \Elemix\Handler\ClassHandler($classes);
}

function start(
    string $template,
    array $data = [],
): void {
    Elemix\Component::getInstance()->start($template, $data);
}

function stop(
    string $template,
): string {
    return Elemix\Component::getInstance()->stop($template);
}

function render(
    string $template,
    array $data = [],
): string {
    return Elemix\Component::getInstance()->render($template, $data);
}
