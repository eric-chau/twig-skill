# Twig skill

This skill is an integration of `Twig` into Jarvis micro-framework.

## Configuration options

To pass options to Twig you must provide a `twig` settings key like this:

```php
<?php

require_once __DIR__.'/vendor/autoload.php';

$jarvis = new Jarvis\Jarvis([
    'container_provider' => [
        'Jarvis\Skill\Twig\ContainerProvider',
    ],
    'twig' => [
        'templates_paths' => '/path/to/templates',
    ],
]);
```

Note that `templates_paths` is a required parameter. This skill changes default values for some options:

- `debug`: if not provided, this value take the value of Jarvis `debug` parameter.
- `auto_reload`: this is setted to `true` as default value in this skill.
- `strict_variables`: this option is also setted to `true` by default.

You can see complete options list on [Twig documentation](http://twig.sensiolabs.org/doc/api.html#environment-options).
