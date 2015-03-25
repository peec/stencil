<!doctype html>
<html>
<head>
    <title><?php echo 'hello world' ?></title>
</head>
<body>

<h1>Examples</h1>


<h3>Variables</h3>

<!-- STENCIL -->
<p>Setting variables are just standard php.</p>
@{$test = 1+2}

<!-- PHP -->
<p>And can also be done in regular php</p>
<?php $test = 1+2; ?>


<!-- STENCIL -->
@{$items = ["hello", "world"]}

<!-- PHP -->
<?php $items = ["hello", "world"]; ?>




<h3>Logic:</h3>



<p>Wrap logic in @ {/*Standard php here.*/}</p>


<!-- STENCIL -->
@{if ($test == 3):}
    <p>$test equals 3.</p>
@{endif}

<!-- PHP -->
<?php if ($test == 3): ?>
    <p>$test equals 3.</p>
<?php endif ?>




<p>Loops is just PHP.</p>

<!-- STENCIL -->
<ul>
@{foreach ($items as $item):}
    <li>{{$item}}</li>
@{endforeach}
</ul>


<!-- PHP -->
<ul>
    <?php foreach ($items as $item): ?>
    <li><?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8')  ?></li>
    <?php endforeach ?>
</ul>





<p>Use filters on internal logic</p>

<!-- STENCIL -->
@{$test = $filter(1000)->plus(300)->plus(30)->plus(7)}
<p>{{$test}}</p>

<!-- PHP -->
<?php $test = $filter(1000)->plus(300)->plus(30)->plus(7); ?>
<p>{{$test}}</p>



<h3>Outputing</h3>


<h3>Built in filters</h3>


<p>By default, XSS escaping is done when using { { "hello" } }.</p>

<p>{{$test .  " this is just php <script>alert('xss safe..');</script>.."}}</p>


<p>{{"This is a raw string. <script>console.log('not xss safe 1..')</script>"}->raw()}</p>


<p>Filters can be applied with { { "hello" } ->filterfunction()->filterfunction2() }</p>



<h3>Custom filters</h3>


<p>My filter returns: {{1000}->plus(300)->plus(30)->plus(7)->plus(2)->minus_both(1,1)}</p>


</body>
</html>
