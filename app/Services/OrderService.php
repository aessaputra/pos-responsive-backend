<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderService
{
    public function processOrder(array $data, User $cashier): Order
    {
        $items = $data['items'];
        $productIds = Arr::pluck($items, 'product_id');

        $products = Product::find($productIds)->keyBy('id');

        foreach ($items as $item) {
            $product = $products->get($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                throw new InvalidArgumentException("Stock for product {$product->name} is not sufficient.");
            }
        }

        return DB::transaction(function () use ($items, $products, $cashier, $data) {
            $totalPrice = 0;
            $totalItems = 0;

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                $totalPrice += $product->price * $item['quantity'];
                $totalItems += $item['quantity'];
            }

            $order = Order::create([
                'transaction_number' => 'TRX-' . now()->timestamp . '-' . strtoupper(uniqid()),
                'cashier_id' => $cashier->id,
                'total_price' => $totalPrice,
                'total_item' => $totalItems,
                'payment_method' => $data['payment_method'],
            ]);

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $product->price * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });
    }
}
