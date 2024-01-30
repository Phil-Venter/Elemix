<?php weave_layout('layout::single', [ 'title' => 'Main Page' ]) ?>

<?php if ($error ?? false): ?>
    <?php weave_section('alert') ?>
        <?php weave_component('component::alert', ['class' => 'bg-red-200 border-red-600 text-red-900 mb-4', 'title' => ($error['title'] ?? null)]) ?>
            <?= $error['message'] ?? '' ?>
        <?php weave_end_component() ?>
    <?php weave_end_section() ?>
<?php endif ?>

Carry on my wayward son