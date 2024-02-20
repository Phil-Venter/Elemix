<article :class="classify('p-4')->merge($class ?? null)">
    <?= $slot ?>
</article>