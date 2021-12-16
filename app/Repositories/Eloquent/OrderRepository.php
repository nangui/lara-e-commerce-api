<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\IOrderRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends BaseRepository implements IOrderRepository
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    /**
     * @throws AuthorizationException
     */
    public function chart(): Collection
    {
        \Gate::authorize('view', 'orders');
        return $this->model->query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%d-%m') as date, SUM(order_items.quantity*order_items.price) as sum")
            ->groupBy('date')
        ->get();
    }
}
