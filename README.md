# Elemix

**Component-Driven PHP Templating System**

Elemix is a small simple yet powerful and flexible PHP templating system designed to streamline the development of dynamic web applications. By leveraging a component-driven approach, Elemix enables developers to build reusable and maintainable code, enhancing productivity and facilitating collaboration.

## Features

- **Component-Based Architecture**: Organize your UI into manageable, reusable components for a cleaner and more maintainable codebase.
- **Class Handling**: Dynamically manage CSS classes for your components, allowing for more flexible styling.
- **Path Management**: Configure and manage paths for components and templates, simplifying the organization of your project's file structure.

## Installation

[TBA]

Ensure your project follows the PSR-4 autoloading standard to seamlessly autoload Elemix classes.

## Quick Start

### Setting Up

First, initialize Elemix by setting up the path handler and binding the component handler:

```php
require_once __DIR__ . '/../vendor/autoload.php';

// Initialize Handlers
$pathHandler = new Elemix\Handler\PathHandler(__DIR__ . '/components/', 'tmpl.php');
$renderHandler = new Elemix\Handler\RenderHandler($pathHandler);
$componentHandler = new Elemix\Handler\ComponentHandler($renderHandler);

// Bind the main Component Handler
Elemix\Component::bind($componentHandler);
```

### Rendering Components

To render a component, use the `Elemix\Component::render` method with the component's template name and any data you wish to pass:

```php
echo Elemix\Component::render('template::main', ['name' => 'World']);
```

### Creating Components

Components are defined in `.tmpl.php` files within your specified components directory. Use the `c-` prefix to denote component tags in your templates.

Example (`components/card/card.tmpl.php`):

```php
<div class="card">
  <div class="card-header"><?= $title ?></div>
  <div class="card-body"><?= $content ?></div>
</div>
```

## Advanced Usage

### Custom Class Handling

Utilize the `Elemix\Component::classify` method to dynamically manage CSS classes for components:

```php
$classHandler = Elemix\Component::classify('btn btn-primary');
echo $classHandler; // Outputs: btn btn-primary
```

### Utilizing Optional Syntax for Component Definition [WIP]

Elemix introduces an optional syntax that simplifies the definition of components within your templates, making them more readable and easier to manage. This feature allows developers to write component tags in a manner similar to HTML, enhancing the development experience without sacrificing the power or flexibility of PHP.

#### Before Compilation

Traditionally, components in Elemix are called using PHP methods, as shown below:

```php
<?php Elemix\Component::start('container') ?>
    <?= Elemix\Component::render('image', ['src' => '<url>']) ?>
<?= Elemix\Component::end() ?>
```

#### Optional Syntax

With the optional syntax and the help of `CompilationHandler`, the same component structure can be written as:

```html
<c-container>
    <c-image src="<url>"/>
</c-container>
```

#### Enabling Optional Syntax

To use this syntax, your project must utilize the `CompilationHandler`, which parses and compiles these custom tags into their PHP equivalents during the template compilation process. This ensures that the templates remain performant, as the compilation step is done ahead of time, and not during every request.

##### Steps to Implement:

1. **Configure `CompilationHandler`**: Ensure that your `CompilationHandler` is properly set up and integrated into your project's template rendering pipeline.

2. **Write Templates Using Optional Syntax**: Create your templates using the simplified component tags. You can mix traditional PHP and this optional syntax within the same template file.

3. **Compile Templates**: During the build or deployment process, run your templates through the `CompilationHandler`. This process converts the simplified syntax into executable PHP code, ready for server-side rendering.

4. **Deployment**: Deploy the compiled templates as part of your application. The compiled code is optimized for performance, eliminating the need for real-time compilation on the server.

#### Benefits

- **Improved Readability**: The optional syntax closely resembles standard HTML, making templates easier to understand and edit, especially for front-end developers familiar with HTML but less so with PHP.
- **Maintainability**: Simplifies template management by abstracting the PHP logic into a more declarative form.
- **Performance**: Pre-compiling templates ensures that the conversion overhead is incurred only once, improving runtime performance.

## Contributing

Contributions are welcome! Feel free to submit pull requests or create issues for bugs, features, or documentation improvements.

## License

Elemix is open-sourced software licensed under the [MIT license](LICENSE.md).
