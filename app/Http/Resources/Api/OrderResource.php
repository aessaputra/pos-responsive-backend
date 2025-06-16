<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\OrderItemResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_number' => $this->transaction_number,
            'cashier_name' => $this->cashier->name,
            'total_price' => (float) $this->total_price,
            'total_item' => (int) $this->total_item,
            'payment_method' => $this->payment_method,
            'order_date' => $this->created_at->toDateTimeString(),
            'items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
