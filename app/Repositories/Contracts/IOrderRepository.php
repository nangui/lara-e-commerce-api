<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface IOrderRepository extends IRepository
{
    public function chart(): Collection;
}
