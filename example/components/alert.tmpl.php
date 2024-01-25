<?php
    $_defaultColor = 'teal';
    $_colorMapping = [
        'red' => ['border-red-500', 'bg-red-50', 'text-red-800', 'text-red-700'],
        'green' => ['border-green-500', 'bg-green-50', 'text-green-800', 'text-green-700'],
        'teal' => ['border-teal-500', 'bg-teal-50', 'text-teal-800', 'text-teal-700'],
    ];

    [
      $_mainBorderColor,
      $_mainBackgroundColor,
      $_titleTextColor,
      $_bodyTextColor
    ] = ($_colorMapping[$color ?? $_defaultColor] ?? $_colorMapping[$_defaultColor]);

    $_class = fw_class('rounded border-s-4 p-4')
      ->merge([
        $_mainBorderColor,
        $_mainBackgroundColor
      ])
      ->merge($class ?? null);
?>

<div role="alert" <?= $_class ?>>
  <?php if (isset($title)) { ?>
    <strong class="block font-medium <?= $_titleTextColor ?>"><?= $title ?></strong>
  <?php } ?>
  <div class="<?= isset($title) ? 'mt-2' : '' ?> text-sm <?= $_bodyTextColor ?>"><?= $slot ?></div>
</div>