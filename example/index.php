<?php

use FST\Weave\Component;

require_once __DIR__ . '/../vendor/autoload.php';

Component::bind(new FST\Weave\Handler\ComponentHandler(__DIR__ . '/components/'));

?>

<script src="https://cdn.tailwindcss.com"></script>


<?php fw_push('container') ?>
    <?php fw_push('alert', ['class' => 'mt-4', 'color' => 'red', 'title' => 'FOO']) ?>
        consequat voluptate Lorem voluptate id occaecat irure laborum Lorem id eu sit elit ad qui ad occaecat non ad tempor
    <?php fw_pop() ?>

    <?php fw_push('alert', ['class' => 'mt-4', 'title' => 'BAR']) ?>
        consectetur enim dolor exercitation adipisicing culpa pariatur ea aliqua duis
    <?php fw_pop() ?>

    <?php fw_push('alert', ['class' => 'mt-4', 'color' => 'green', 'title' => 'BAZ']) ?>
        consequat ex enim labore nulla id laboris non culpa elit
    <?php fw_pop() ?>
<?php fw_pop() ?>