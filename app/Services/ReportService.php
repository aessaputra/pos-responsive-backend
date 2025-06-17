<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class ReportService
{
    public function generateDetailedReport(Carbon $startDate, Carbon $endDate): array
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $orderIds = $orders->pluck('id');

        if ($orderIds->isEmpty()) {
            return [
                'items' => [],
                'totals' => ['total_quantity' => 0, 'grand_total' => 0],
            ];
        }

        $items = OrderItem::query()
            ->whereIn('order_id', $orderIds)
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('products.name', 'asc')
            ->get();

        $totalQuantity = $items->sum('total_quantity');
        $grandTotal = $items->sum('total_revenue');

        return [
            'items' => $items->toArray(),
            'totals' => [
                'total_quantity' => $totalQuantity,
                'grand_total' => $grandTotal,
            ],
        ];
    }
}
