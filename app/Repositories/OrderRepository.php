<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryContract;

class OrderRepository implements OrderRepositoryContract
{
    public function create(array $data): Order|bool
    {
        dd($data);
    }
}
