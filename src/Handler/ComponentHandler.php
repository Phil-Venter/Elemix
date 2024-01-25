<?php

declare(strict_types=1);

namespace FST\Weave\Handler;

use FST\Weave\Contract\ComponentHandlerContract;
use FST\Weave\Exception\ComponentDirectoryNotExistException;
use FST\Weave\Exception\ComponentDoesNotExistException;
use FST\Weave\Exception\ComponentExpectsDataToBeAnAssocArray;
use FST\Weave\Exception\ComponentStackIsEmptyException;
use FST\Weave\Exception\ComponentUsingAReservedKeyException;

/**
 * The ComponentHandler class is responsible for managing components,
 * including pushing and popping components from the stack,
 * rendering components, and handling component-related exceptions.
 */
class ComponentHandler implements ComponentHandlerContract
{
    /**
     * @var array Stack to hold the components.
     */
    protected array $stack = [];

    /**
     * Component constructor.
     *
     * @param string $directory The directory where components are located.
     * @param string $extension The file extension for component files.
     * @param string $placeholder The placeholder name used within components.
     *
     * @throws ComponentDirectoryNotExistException If the specified directory does not exist.
     */
    public function __construct(
        protected string $directory,
        protected string $extension = 'tmpl.php',
        protected string $placeholder = 'slot',
    ) {
        if (!is_dir($directory)) {
            throw new ComponentDirectoryNotExistException($directory);
        }

        $this->directory = rtrim($directory, '/');
    }

    /**
     * Pushes a new component onto the stack and starts output buffering.
     *
     * @param string $template The template file of the component.
     * @param array $data The data to be passed to the component.
     *
     * @throws ComponentUsingAReservedKeyException If the data array contains a key that matches the placeholder.
     */
    public function push(string $template, array $data = []): void
    {
        if ([] !== $data && array_is_list($data)) {
            throw new ComponentExpectsDataToBeAnAssocArray(__FUNCTION__);
        }

        if (isset($data[$this->placeholder])) {
            throw new ComponentUsingAReservedKeyException($this->placeholder);
        }

        array_push($this->stack, [$template, $data]);
        ob_start();
    }

    /**
     * Pops a component from the stack, renders it, and outputs the result.
     *
     * @throws ComponentStackIsEmptyException If the stack is empty.
     */
    public function pop(): void
    {
        if (empty($this->stack)) {
            throw new ComponentStackIsEmptyException;
        }

        [$template, $data] = array_pop($this->stack);
        $data[$this->placeholder] = ob_get_clean();

        echo $this->render($template, $data);
    }

    /**
     * Renders a component template with the given data.
     *
     * @param string $template The template file of the component.
     * @param array $data The data to be passed to the component.
     *
     * @throws ComponentDoesNotExistException If the component file does not exist.
     *
     * @return string The rendered component.
     */
    public function render(string $template, array $data = []): string
    {
        if ([] !== $data && array_is_list($data)) {
            throw new ComponentExpectsDataToBeAnAssocArray(__FUNCTION__);
        }

        if (!isset($data[$this->placeholder])) {
            $data[$this->placeholder] = '';
        }

        extract($data);

        ob_start();
        include $this->createPathFromName($template);
        return ob_get_clean();
    }

    /**
     * Creates a file path from the component name.
     *
     * @internal
     *
     * @param string $template The template file of the component.
     *
     * @throws ComponentDoesNotExistException If the component file does not exist.
     *
     * @return string The full path to the component file.
     */
    protected function createPathFromName(string $template): string
    {
        $path = sprintf('%s/%s.%s', $this->directory, $template, $this->extension);

        if (!is_file($path)) {
            throw new ComponentDoesNotExistException($path);
        }

        return $path;
    }
}
