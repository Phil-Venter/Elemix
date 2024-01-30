<?php

declare(strict_types=1);

if (!function_exists('weave_classify')) {
    function weave_classify(array|string|null $classes): FST\Weave\Handler\Classify
    {
        return new FST\Weave\Handler\Classify($classes);
    }
}

if (!function_exists('weave_component')) {
    function weave_component(string $template, array $data = []): void
    {
        FST\Weave\Weave::getInstance()->getComponent()->start($template, $data);
    }
}

if (!function_exists('weave_end_component')) {
    function weave_end_component(): void
    {
        FST\Weave\Weave::getInstance()->getComponent()->stop();
    }
}

if (!function_exists('weave_layout')) {
    function weave_layout(string $template, array $data = []): void
    {
        FST\Weave\Weave::getInstance()->getTemplate()->layout($template, $data);
    }
}

if (!function_exists('weave_section')) {
    function weave_section(string $name): void
    {
        FST\Weave\Weave::getInstance()->getTemplate()->start($name);
    }
}

if (!function_exists('weave_end_section')) {
    function weave_end_section(): void
    {
        FST\Weave\Weave::getInstance()->getTemplate()->stop();
    }
}

if (!function_exists('weave_get_section')) {
    function weave_get_section(string $name, $default = null): void
    {
        echo FST\Weave\Weave::getInstance()->getTemplate()->sections[$name] ?? $default ?? '';
    }
}

if (!function_exists('weave_fetch')) {
    function weave_fetch(string $template, array $data = []): string
    {
        return FST\Weave\Weave::getInstance()->makeTemplate($template, $data)->render();
    }
}

if (!function_exists('weave_insert')) {
    function weave_insert(string $template, array $data = []): void
    {
        echo FST\Weave\Weave::getInstance()->makeTemplate($template, $data)->render();
    }
}