<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\IOrderRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private IOrderRepository $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function chart(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->orderRepository->chart();
    }
}
