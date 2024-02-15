<?php if (!empty($image ?? null)) : ?>
    <?php $class = classify(
        'w-full'
    )->merge($class ?? null) ?>

    <img :class="$class" :src="$image" :alt="$alt">
<?php endif ?>