<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $faker;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * Reset the migrations
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}
