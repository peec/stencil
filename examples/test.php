<?php
require '../vendor/autoload.php';
$time = microtime(true);

use \Pkj\Stencil\Stencil,
    \Pkj\Stencil\FilterChainer;


//
// CUSTOM FILTERS
//


FilterChainer::appendFilter('plus', function ($value, $sum) {
    return $value + $sum;
});
FilterChainer::appendFilter('minus_both', function ($value, $val1, $val2) {
    return $value - $val1 - $val2;
});


//
// GET INSTANCE OF STENCIL
//

$stencil = Stencil::getInstance();

//
// OPTIONAL: CACHE PHP.
//

$stencil->setCacheAdapter(new \Pkj\Stencil\FileCacheAdapter('./compiled', '.'));



//
// CREATE A RESOURCE.
//


$resource = $stencil->resource('test-template.stencil.php');


//
// RENDER THE RESOURCE.
//


echo $resource->render();


echo "<p>Rendered in ".(microtime(true) -  $time)." </p>";
