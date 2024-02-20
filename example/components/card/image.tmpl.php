<?php if (!empty($image ?? null)) : ?>
    <img :class="classify('w-full')->merge($class ?? null)" :src="$image" :alt="$alt">
<?php endif ?>