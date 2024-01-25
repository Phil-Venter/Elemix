<?php
    $_class = fw_class("container mx-auto")
        ->merge($class ?? null)
        ->attr();
?>

<section <?= $_class ?>><?= $slot ?></section>