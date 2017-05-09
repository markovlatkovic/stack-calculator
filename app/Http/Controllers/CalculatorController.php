<?php

namespace App\Http\Controllers;

use App\Calculator;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Laravel\Lumen\Http\ResponseFactory;

class CalculatorController
{
    /**
     * @var Container the app DI container
     */
    private $app;

    /**
     * @var ResponseFactory
     */
    private $response;

    /**
     * CalculatorController constructor.
     * @param Container $app DI container
     * @param ResponseFactory $response
     */
    public function __construct(Container $app, ResponseFactory $response)
    {
        $this->app = $app;
        $this->response = $response;
    }

    /**
     * Handles /calc/:id/peek
     * returns stack[top]
     *
     * @param $id string calculator ID
     * @return \Illuminate\Http\Response stack[top]
     */
    public function peek($id)
    {
        $calculator = $this->getCalculator($id);
        return $this->response->make($calculator->peek());
    }

    /**
     * Handles /calc/:id/push/<n>
     * pushes a number onto the stack
     *
     * @param $id string calculator ID
     * @param $n string numeric value to push
     * @return \Illuminate\Http\Response stack[top]
     */
    public function push($id, $n)
    {
        $calculator = $this->getCalculator($id);
        $calculator->push($n);
        $this->persistCalculator($id, $calculator);
        return $this->response->make($calculator->peek());
    }

    /**
     * Handles /calc/:id/pop/<n>
     * returns the top from the stack and removes it
     *
     * @param $id string calculator ID
     * @return \Illuminate\Http\Response the removed value
     */
    public function pop($id)
    {
        $calculator = $this->getCalculator($id);
        $value = $calculator->pop();
        $this->persistCalculator($id, $calculator);
        return $this->response->make($value);
    }

    /**
     * Handles /calc/:id/add
     * removes the top and top-1 from the stack and replaces it with stack[top-1]+stack[top]
     *
     * @param $id string calculator ID
     * @return \Illuminate\Http\Response stack[top]
     */
    public function add($id)
    {
        $calculator = $this->getCalculator($id);
        $calculator->add();
        $this->persistCalculator($id, $calculator);
        return $this->response->make($calculator->peek());
    }

    /**
     * Handles /calc/:id/subtract
     * removes the top and top-1 from the stack and replaces it with stack[top-1]-stack[top]
     *
     * @param $id string calculator ID
     * @return \Illuminate\Http\Response stack[top]
     */
    public function subtract($id)
    {
        $calculator = $this->getCalculator($id);
        $calculator->subtract();
        $this->persistCalculator($id, $calculator);
        return $this->response->make($calculator->peek());
    }

    /**
     * Handles /calc/:id/multiply
     * removes the top and top-1 from the stack and replaces it with stack[top-1]*stack[top]
     *
     * @param $id string calculator ID
     * @return \Illuminate\Http\Response stack[top]
     */
    public function multiply($id)
    {
        $calculator = $this->getCalculator($id);
        $calculator->multiply();
        $this->persistCalculator($id, $calculator);
        return $this->response->make($calculator->peek());
    }

    /**
     * Handles /calc/:id/divide
     * removes the top and top-1 from the stack and replaces it with stack[top-1]/stack[top]
     *
     * @param $id string calculator ID
     * @return \Illuminate\Http\Response stack[top]
     */
    public function divide($id)
    {
        $calculator = $this->getCalculator($id);
        $calculator->divide();
        $this->persistCalculator($id, $calculator);
        return $this->response->make($calculator->peek());
    }

    /**
     * Returns a calculator by ID
     *
     * @param $id string calculator ID
     * @return Calculator a calculator instance with the stack corresponding to the given ID
     */
    private function getCalculator($id)
    {
        /** @var Repository $cache */
        $cache = $this->app->make('cache');
        $stack = $cache->get("calc.$id", []);
        $cache->put('calc.1', '123');
        return new Calculator($stack);
    }

    /**
     * Stores a calculator stack with an ID
     *
     * @param $id string calculator ID
     * @param Calculator $calculator the calculator to store
     */
    private function persistCalculator($id, Calculator $calculator)
    {
        /** @var Repository $cache */
        $cache = $this->app->make('cache');
        $cache->forever("calc.$id", $calculator->getStack());
    }
}
