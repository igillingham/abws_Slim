<?php

$app->get('/hello/:name', function ($name) 
    {
    echo "Hello, $name";
    });

$app->get('/sum/:n1/:n2', function ($n1, $n2) 
    {
    $res = $n1+$n2;
    echo "Sum: $n1 + $n2 = $res";
    });

$app->error(function (\Exception $e) use ($app) 
    {
    $app->render('error.php');
    });

