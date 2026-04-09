<?php

interface DBProviderInterface
{
    public function store($data);
}

final class Order
{
    public function __construct(private DBProviderInterface $db) {}

    public function createOrder($data)
    {
        $this->db->store($data);
    }
}

class TextDbProvider implements DBProviderInterface
{
    public function store($data)
    {
        dump($data);
    }
}

new Order(new TextDbProvider())->createOrder([
    'dsadsakl' => 'dsakjldas'
]);
