# Twig skill

This skill is an integration of `Twig` into Jarvis micro-framework.

## What it brings

When this skill is enabled, it brings:

- `$app['twig']` service, an unique instance of `\Twig_Environment`.
- On `$app['twig']` first call, the event `Jarvis\Skill\Twig\TwigReadyEvent` (event name: `twig.ready`) will be broadcasted. Note that `TwigReadyEvent` is a permanent event.
- In all Twig templates, the variable `router` (=`$app['router']`) is available.

## Configuration options

You must add a 'twig' key in the 'extra' section to pass your options:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new Jarvis\Jarvis([
    'providers' => [
        'Jarvis\Skill\Twig\TwigCore',
    ],
    'extra' => [
        twig' => [
            'templates_paths' => '/path/to/templates',
        ],
    ],
]);
```

Note that `templates_paths` is a required parameter. Other options:

- `debug`: if not provided, Jarvis `debug` parameter is used.
- `auto_reload`: `true` by default.
- `strict_variables`: `true` by default.

You can see complete options list on [Twig documentation](http://twig.sensiolabs.org/doc/api.html#environment-options).
