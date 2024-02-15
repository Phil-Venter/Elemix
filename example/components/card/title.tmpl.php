<?php $class = classify(
    'text-lg font-medium text-gray-900'
)->merge($class ?? null) ?>

<h3 :class="$class">
    <?= $slot ?>
</h3>