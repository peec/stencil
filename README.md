# Stencil

PHP templating engine, flexible and very fast engine. Templates can be normal php files, or a mix of php and stencil code.

Stencil can parse any PHP file.


## GOAL

- Prevent XSS attacks (forget about echo / print etc. )
- Shorthand syntax for ugly `<?php ?>`.
- Modular
- Super fast and Lightweight


## INSTALL

```bash
composer install
```

## GETTING STARTED

Getting started, include Stencil:

```php
require './vendor/autoload.php';
use \Pkj\Stencil\Stencil;

$stencil = Stencil::getInstance();

$resource = $stencil->resource('mytemplate.stencil.php');

echo $resource->render(array(
    'hello' => 'Hello World!'
));
``

mytemplate.stencil.php:

```php
<!doctype html>
<html>
<head>
    <title>Stencil</title>
</head>
<body>
    <p><?php echo $hello ?> from PHP</p>
    <p>{{$hello}} from Stencil</p>
</body>
</html>
```




## Reserved variables

We reserve some variables to parse the templates.

- `$stencil_*` variables are used internally for parsing.
- `$filter` is a callback that is used to create new FilterChainer instance.



