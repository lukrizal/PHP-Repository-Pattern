<?php

namespace App\Business\Entities;

use \Exception;

abstract class Entity
{
    protected $data = array();

    public function __construct(array $data)
    {
        if (!empty($data)) {
            $this->data = $data;
        }
    }

    public function __set(string $name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function __get(string $name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        throw new Exception('Undefined property');
    }
}