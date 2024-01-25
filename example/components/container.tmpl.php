<?php
    $_class = fw_class("container mx-auto")
        ->merge($class ?? null);
?>

<section <?= $_class ?>><?= $slot ?></section>