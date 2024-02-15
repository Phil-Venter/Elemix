<?php

function classify(array|string|null $classes): Elemix\Contract\ClassHandlerContract
{
    return Elemix\Component::classify($classes);
}