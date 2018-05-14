<?php

namespace Tests\Unit;

use App\Business\Entities\Order;
use App\Business\Order\Repositories\RepositoryInterface;
use Tests\TestCase;


class OrderTest extends TestCase
{
    /**
     * Test the Order Repository
     *
     * @return void
     */
    public function testOrderRepositoryShouldWork()
    {
        /** @var RepositoryInterface $repository */
        $repository = $this->app->make(RepositoryInterface::class);
        $repository->find(['0077-6495-AYUX']);
        /** @var Order $order */
        $order = $repository->get()->first();
        $this->assertTrue($order->trackingNumber === '0077-6495-AYUX');
        $this->assertTrue(is_string($repository->render()));
    }
}
