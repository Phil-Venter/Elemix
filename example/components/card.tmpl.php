<?php $class = classify(
    'p-4'
)->merge($class ?? null) ?>

<article :class="$class">
    <?= $slot ?>
</article>