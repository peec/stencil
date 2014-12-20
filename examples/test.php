<?php
require '../vendor/autoload.php';

use \Pkj\Stencil\Stencil;

$engine = Stencil::resource('test-template.stencil.php');

echo $engine->render();


