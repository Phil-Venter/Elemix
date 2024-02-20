<?php

require_once __DIR__ . '/../vendor/autoload.php';

// SETUP
$pathHandler = (new Elemix\Handler\PathHandler(__DIR__ . '/components/', 'tmpl.php'))
    ->add('card', __DIR__ . '/components/card/')
    ->add('template', __DIR__ . '/templates/');

$compilationCacheDir = __DIR__ . '/.cache/';
if (!is_dir($compilationCacheDir)) {
    mkdir($compilationCacheDir, 0755, true);
}

$compilationCacheHandler = new Elemix\Handler\PathHandler($compilationCacheDir, 'cache.php');
$compilationHandler = new Elemix\Handler\CompilationHandler($pathHandler, $compilationCacheHandler);
$renderHandler = new Elemix\Handler\RenderHandler($compilationHandler);
$componentHandler = new Elemix\Handler\ComponentHandler($renderHandler);

Elemix\Component::bind($componentHandler);

// RUN
echo render('template::main', ['name' => 'Document']);
