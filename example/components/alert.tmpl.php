<div role="alert" <?= weave_classify('rounded border-s-4 p-4')->merge($class ?? null) ?>>
    <?php if (isset($title)): ?>
        <strong class="block font-medium"><?= $title ?></strong>
    <?php endif ?>
    <div <?= weave_classify('text-sm')->merge(['mt-2' => isset($title)]) ?>>
        <?= $slot ?>
    </div>
</div>