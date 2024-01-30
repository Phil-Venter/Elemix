# Weave PHP Templating Engine README

Weave is a lightweight and flexible PHP templating engine inspired by the simplicity and elegance of Blade and Plates. Designed to streamline the process of rendering dynamic HTML content, Weave focuses on providing an intuitive and straightforward API for managing templates, components, and layout compositions.

## Overview

Weave enables developers to create reusable template components, manage content sections, and maintain a clean separation between PHP logic and HTML structure. Drawing inspiration from the well-established Blade and Plates templating engines, Weave allows you to easily bind data to your templates and construct complex layouts with minimal effort.

## Features

- **Classify Component**: Handles dynamic CSS class generation based on conditions, providing a simple interface for managing CSS classes in your HTML templates.
- **Component Management**: Facilitates the creation of reusable, nestable components that can be embedded within other templates or components, promoting code reuse and maintainability.
- **Template Inheritance**: Supports layout inheritance, allowing you to define a base layout and override specific sections in child templates.
- **Content Section Management**: Enables the definition and injection of content sections within layouts and templates, offering flexibility in content organization.
- **Weave Singleton**: Utilizes a singleton pattern for the main engine instance, ensuring a single point of access and management for the templating engine.
- **Directory Management**: Allows specification of multiple directories for organizing templates, enabling the use of a `directory_key::template_name` syntax to reference templates across different directories.

## Getting Started

Before you can utilize the Weave functions, you need to initialize the Weave singleton with your templates directory. Here's how you can do it:

```php
FST\Weave\Weave::bind(new FST\Weave\Engine(__DIR__ . '/templates/'));
```

### Specifying Additional Directories and Custom Template Extension

You can add additional directories to the engine for better organization of your templates and specify a custom template file extension if needed. Once added, you can reference templates in these directories using the `key::template` syntax:

```php
$engine = new FST\Weave\Engine(__DIR__ . '/default_templates/', 'custom_ext.php');
$engine->addDirectory('custom', __DIR__ . '/custom_templates/');
FST\Weave\Weave::bind($engine);

// Now you can reference templates in the custom directory like this:
weave_insert('custom::your_template_name', ['dataKey' => 'dataValue']);
```
The second parameter in the Engine constructor is optional and allows you to define a custom extension for your template files, defaulting to 'tmpl.php'.

## Usage

### Defining and Rendering Templates

Create your templates as PHP files in the designated templates directory. Use the `weave_insert` function to render a template and inject it directly into the HTML output:

```php
weave_insert('your_template_name', ['dataKey' => 'dataValue']);
```

### Working with Components

Define a component start and end in your templates using the `weave_component` and `weave_end_component` functions. This allows you to encapsulate and reuse parts of your templates. Components are nestable, so you can easily compose complex UIs by embedding components within other components:

```php
weave_component('parent_component_name', ['dataKey' => 'dataValue']);
    // Parent component content here
    
    weave_component('child_component_name', ['dataKey' => 'dataValue']);
    // Child component content here
    weave_end_component();
    
weave_end_component();
```

### Managing Layouts and Sections

Use the `weave_layout` function to specify a base layout for your template. Define sections within your templates and layouts using `weave_section` and `weave_end_section`:

```php
weave_layout('layout_name', ['dataKey' => 'dataValue']);
weave_section('section_name');
// Your section content here
weave_end_section();
```

Retrieve and display a section's content using the `weave_get_section` function:

```php
weave_get_section('section_name', 'Default content if section is not set');
```

### Fetching Rendered Content

To fetch the rendered content of a template as a string (instead of directly outputting it), use the `weave_fetch` function:

```php
$content = weave_fetch('your_template_name', ['dataKey' => 'dataValue']);
```

## Handling Exceptions

Be mindful of the custom exceptions provided by Weave:

- `ExpectsDataToBeAnAssocArray`: Ensures that the data passed to components and templates are associative arrays.
- `StackIsEmptyException`: Thrown when attempting to stop a component or section without a corresponding start.
- `UsageOfAReservedKeyForbiddenException`: Prevents the use of reserved keys in your data arrays.
- `DirectoryDoesNotExistException`: Ensures that the specified template directory exists.
- `EngineNotBoundException`: Ensures that the Weave engine is properly initialized before use.

Handle these exceptions appropriately in your application to ensure a smooth templating experience.

## Conclusion

Weave provides a simple yet powerful templating engine for PHP, offering an easy way to manage templates, components, and layouts. The addition of directory management for organizing templates enriches Weave's flexibility, enabling sophisticated and dynamic web page structures. By following the guidelines in this README, you can leverage Weave's features to create maintainable and reusable template structures for your PHP applications.