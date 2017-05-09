<?php

$app->group(['prefix' => '/calc/{id}'], function () use ($app) {

    $app->get('/peek', 'CalculatorController@peek');
    $app->get('/push/{n}', 'CalculatorController@push');
    $app->get('/pop', 'CalculatorController@pop');
    $app->get('/add', 'CalculatorController@add');
    $app->get('/subtract', 'CalculatorController@subtract');
    $app->get('/multiply', 'CalculatorController@multiply');
    $app->get('/divide', 'CalculatorController@divide');

});
