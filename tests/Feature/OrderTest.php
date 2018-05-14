<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/api/orders');
        $response->assertStatus(201);
    }
}
