<?php

declare(strict_types=1);

namespace FST\Weave\Handler;

use FST\Weave\Engine;
use FST\Weave\Exception\ExpectsDataToBeAnAssocArray;
use FST\Weave\Exception\StackIsEmptyException;
use FST\Weave\Exception\UsageOfAReservedKeyForbiddenException;

use function array_pop;
use function array_push;
use function ob_get_clean;
use function ob_start;

class Component
{
    protected const RESERVED_KEY = 'slot';
    protected array $stack = [];

    public function __construct(
        protected Engine $engine,
    ) {
    }

    public function start(string $template, array $data = []): void
    {
        if ([] !== $data && array_is_list($data)) {
            throw new ExpectsDataToBeAnAssocArray;
        }

        if (isset($data[self::RESERVED_KEY])) {
            throw new UsageOfAReservedKeyForbiddenException(self::RESERVED_KEY);
        }

        array_push($this->stack, [$template, $data]);
        ob_start();
    }

    public function stop(): void
    {
        if (empty($this->stack)) {
            throw new StackIsEmptyException;
        }

        [$template, $data] = array_pop($this->stack);
        $data[self::RESERVED_KEY] = ob_get_clean();

        echo $this->engine
            ->makeTemplate($template, $data)
            ->render();
    }
}