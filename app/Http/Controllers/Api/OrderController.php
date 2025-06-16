<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
        //
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->processOrder(
                $request->validated(),
                $request->user()
            );

            $order->load('orderItems.product', 'cashier');

            return (new OrderResource($order))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => 'Failed to create order.',
                'errors' => ['stock' => $e->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
