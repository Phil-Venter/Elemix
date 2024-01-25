<?php

use FST\Weave\Component;
use FST\Weave\Handler\ComponentHandler;

require_once __DIR__ . '/../vendor/autoload.php';

Component::bind(
    (new ComponentHandler(__DIR__ . '/templates/'))
        ->addDirectory('component', __DIR__ . '/components/')
);

fw_render('main');
