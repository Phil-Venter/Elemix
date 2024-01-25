<?php

declare(strict_types=1);

namespace FST\Weave\Contract;

interface ComponentHandlerContract
{
    /**
     * Push a new component onto the stack.
     *
     * @param string $template The template name.
     * @param array $data The data to be passed to the template.
     */
    public function push(string $template, array $data = []): void;

    /**
     * Pop the last component from the stack and render it.
     */
    public function pop(): void;

    /**
     * Render a template with the provided data.
     *
     * @param string $template The template name.
     * @param array $data The data to be passed to the template.
     *
     * @return string The rendered template.
     */
    public function render(string $template, array $data = []): string;
}
