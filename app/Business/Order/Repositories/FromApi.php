<?php

namespace App\Business\Order\Repositories;

use App\Business\Entities\Order as OrderEntity;
use App\Business\Entities\OrderHistory as HistoryEntity;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Moment\MomentException;

class FromApi implements RepositoryInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Collection
     */
    protected $collections;

    protected $promises = array();

    protected $baseUri;

    public function __construct(string $baseUri)
    {
        $this->client = new Client();
        $this->collections = collect();
        $this->baseUri = $baseUri;
    }

    /**
     * @param array $ids
     * @return Collection|void
     * @throws MomentException
     */
    public function find(array $ids)
    {
        $options = [
            'headers' => [
                'X-Time-Zone' => 'Asia/Manila'
            ]
        ];
        collect($ids)->map(function ($id) use ($options) {
            array_push($this->promises, $this->client->requestAsync('GET', $this->generateUrl($id), $options));
        })
        ->reject(function ($id) {
            return empty($id);
        });

        $requests = Promise\settle($this->promises)->wait();
        foreach ($requests as $result) {
            if ($result['state'] === 'fulfilled') {
                $this->parse($result['value']);
            }
        }
    }

    public function getSourceType()
    {
        return 'api';
    }

    /**
     * Render collection
     *
     * @param bool $console
     * @return string
     */
    public function render(bool $console = false)
    {
        $output = "";
        $newLine = $console ? "" : "<br>";
        $tab = $console ? "  " : "&nbsp;&nbsp;";
        $this->collections->map(function (OrderEntity $entity) use ($newLine, $tab, &$output) {
            $tat = "";
            $entity->histories->map(function (HistoryEntity $historyEntity) use ($newLine, $tab, &$tat) {
                $tat .= sprintf("{$tab}%s: %s{$newLine}
                ",
                $historyEntity->eventDate, $historyEntity->eventState);
            });
            $output .= "{$entity->trackingNumber} ({$entity->status}) {$newLine}
            {$tab}history: {$newLine}
            {$tab}{$tat}breakdown: {$newLine}
            {$tab}{$tab}subtotal: {$entity->subtotal} {$newLine}
            {$tab}{$tab}shipping: {$entity->shipping} {$newLine}
            {$tab}{$tab}tax: {$entity->tax} {$newLine}
            {$tab}{$tab}fee: {$entity->fee} {$newLine}
            {$tab}{$tab}insurance: {$entity->insurance} {$newLine}
            {$tab}{$tab}discount: {$entity->discount} {$newLine}
            {$tab}{$tab}total: {$entity->total} {$newLine}
            {$tab}fees: {$newLine}
            {$tab}{$tab}shipping fee: {$entity->shippingFee} {$newLine}
            {$tab}{$tab}insurance_fee: {$entity->insuranceFee} {$newLine}
            {$tab}{$tab}transaction_fee: {$entity->transactionFee} {$newLine}";
        });

        return $output;
    }

    /**
     * return the collection
     *
     * @return Collection
     */
    public function get()
    {
        return $this->collections;
    }

    private function generateUrl($id) {
        return $this->baseUri .'/'. $id;
    }

    /**
     * @param Response $response
     * @throws MomentException
     */
    private function parse(Response $response)
    {
        // convert response json to object
        $obj = \GuzzleHttp\json_decode($response->getBody());

        // get only needed properties and create Order
        $data = [
            'trackingNumber' => $obj->tracking_number,
            'status' => $obj->status,
            'subtotal' => $obj->subtotal,
            'shipping' => $obj->shipping,
            'tax' => $obj->tax,
            'fee' => $obj->fee,
            'insurance' => $obj->insurance_fee,
            'discount' => $obj->discount,
            'total' => $obj->total,
            'transactionFee' => $obj->transaction_fee,
            'insuranceFee' => $obj->insurance_fee,
            'shippingFee' => $obj->shipping_fee,
        ];
        $order = new OrderEntity($data);

        // parse history
        foreach ($obj->tat as $state => $tat) {
            $history = new HistoryEntity([
                'eventDate' => $tat->date,
                'eventState' => $state
            ]);
            $order->addHistory($history);
        }

        // add the order to our current collection
        $this->collections->push($order);
    }
}