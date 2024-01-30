<?php

require_once __DIR__ . '/../vendor/autoload.php';

FST\Weave\Weave::bind((new FST\Weave\Engine(__DIR__ . '/templates/'))
    ->addDirectory('layout', __DIR__ . '/layouts/')
    ->addDirectory('component', __DIR__ . '/components/'));

echo FST\Weave\Weave::getInstance()
    ->makeTemplate('main', ['error' => ['title' => 'FOO', 'message' => 'BAR']])
    ->render();
