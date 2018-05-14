<?php

namespace App\Business\Entities;

use Illuminate\Support\Collection;

/**
 * @property Collection histories
 * @property string status
 * @property string trackingNumber
 * @property float subtotal
 * @property float shipping
 * @property float tax
 * @property float fee
 * @property float insurance
 * @property float discount
 * @property float total
 * @property float transactionFee
 * @property float insuranceFee
 * @property float shippingFee
 */
class Order extends Entity
{
    /**
     * @param OrderHistory $history
     * @return Order
     */
    public function addHistory(OrderHistory $history) {
        if (!array_key_exists('histories', $this->data)) {
            $this->data['histories'] = collect();
        }
        if ($this->historyExists($history)) {
            return $this;
        }
        $this->histories->push($history);

        return $this;
    }

    public function historyExists(OrderHistory $history) {
        return $this->histories->contains($history);
    }
}