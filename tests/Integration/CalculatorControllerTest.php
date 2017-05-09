<?php

namespace Tests\Integration;


use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CalculatorControllerTest extends TestCase
{
    public function testPushPeekPop()
    {
        $this->assertRequest('/calc/1/push/20', '20');
        $this->assertRequest('/calc/1/peek', '20');
        $this->assertRequest('/calc/1/pop', '20');
    }

    public function testAddSubtractMultiplyDivide()
    {
        $this->get('/calc/1/push/24');
        $this->get('/calc/1/push/2');
        $this->get('/calc/1/push/3');
        $this->get('/calc/1/push/4');
        $this->get('/calc/1/push/5');
        // [24, 2, 3, 4, 5]
        $this->assertRequest('/calc/1/add', '9');
        // [24, 2, 3, 9]
        $this->assertRequest('/calc/1/subtract', '-6');
        // [24, 2, -6]
        $this->assertRequest('/calc/1/multiply', '-12');
        // [24, -12]
        $this->assertRequest('/calc/1/divide', '-2');
        // [-2]
    }

    public function testMultipleCalculators()
    {
        $this->get('/calc/1/push/1');
        $this->get('/calc/2/push/2');
        $this->get('/calc/1/push/3');
        $this->get('/calc/2/push/4');
        // 1: [1, 3]
        // 2: [2, 4]

        $this->assertRequest('/calc/1/peek', '3');
        $this->assertRequest('/calc/2/peek', '4');
        $this->assertRequest('/calc/1/add', '4');
        $this->assertRequest('/calc/2/multiply', '8');
    }

    public function testPeekEmpty()
    {
        $this->assertRequest('/calc/1/peek', 'error: stack underflow', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function testPushInvalidArgument()
    {
        $this->get('/calc/1/push/1');
        $this->assertRequest('/calc/1/push/x', 'error: invalid argument', Response::HTTP_INTERNAL_SERVER_ERROR);
        $this->assertRequest('/calc/1/peek', '1');
    }

    public function testStackUnderflowErrorsForOperations()
    {
        foreach (['add', 'subtract', 'multiply', 'divide'] as $i => $operation) {
            $this->assertRequest("/calc/$i/$operation", 'error: stack underflow', Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->get("/calc/$i/push/1");
            $this->assertRequest("/calc/$i/$operation", 'error: stack underflow', Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->assertRequest("/calc/$i/peek", '1');
        }
    }

    public function testDivisionByZeroError()
    {
        $this->get('/calc/1/push/1');
        $this->get('/calc/1/push/0');
        $this->assertRequest("/calc/1/divide", 'error: division by zero', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function testExampleInRequirements()
    {
        $this->assertRequest('/calc/1/push/1', '1');
        $this->assertRequest('/calc/1/push/4', '4');
        $this->assertRequest('/calc/1/add', '5');
        $this->assertRequest('/calc/1/push/10', '10');
        $this->assertRequest('/calc/1/multiply', '50');
        $this->assertRequest('/calc/1/push/2', '2');
        $this->assertRequest('/calc/1/divide', '25');
        $this->assertRequest('/calc/2/peek', 'error: stack underflow', Response::HTTP_INTERNAL_SERVER_ERROR);
        $this->assertRequest('/calc/2/push/20', '20');
        $this->assertRequest('/calc/2/divide', 'error: stack underflow', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function assertRequest($uri, $expectedContent, $expectedStatus = Response::HTTP_OK)
    {
        $this->get($uri);
        $this->assertEquals($expectedContent, $this->response->getContent());
        $this->assertResponseStatus($expectedStatus);
    }
}
