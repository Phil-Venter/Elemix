<?php $class = classify([
    'border-red-500 bg-red-300 text-red-900' => $red ?? false,
])->merge($class ?? null) ?>

<p :class="$class">
    <?= $slot ?>
</p>