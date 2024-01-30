<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php weave_component('component::container', ['class' => 'my-4']) ?>
        <?php weave_get_section('alert', '') ?>
        <?php weave_get_section('content') ?>
    <?php weave_end_component() ?>
</body>
</html>