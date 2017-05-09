<?php

namespace Tests\Integration;


use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CalculatorControllerTest extends TestCase
{
    public function testPushPeekPop()
    {
        $this->get('/calc/1/push/20');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('20', $this->response->getContent());

        $this->get('/calc/1/peek');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('20', $this->response->getContent());

        $this->get('/calc/1/pop');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('20', $this->response->getContent());
    }

    public function testAddSubtractMultiplyDivide()
    {
        $this->get('/calc/1/push/24');
        $this->get('/calc/1/push/2');
        $this->get('/calc/1/push/3');
        $this->get('/calc/1/push/4');
        $this->get('/calc/1/push/5');
        // [24, 2, 3, 4, 5]

        $this->get('/calc/1/add');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('9', $this->response->getContent());
        // [24, 2, 3, 9]

        $this->get('/calc/1/subtract');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('-6', $this->response->getContent());
        // [24, 2, -6]

        $this->get('/calc/1/multiply');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('-12', $this->response->getContent());
        // [24, -12]

        $this->get('/calc/1/divide');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('-2', $this->response->getContent());
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

        $this->get('/calc/1/peek');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('3', $this->response->getContent());

        $this->get('/calc/2/peek');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('4', $this->response->getContent());

        $this->get('/calc/1/add');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('4', $this->response->getContent());

        $this->get('/calc/2/multiply');
        $this->assertResponseStatus(Response::HTTP_OK);
        $this->assertEquals('8', $this->response->getContent());
    }
}