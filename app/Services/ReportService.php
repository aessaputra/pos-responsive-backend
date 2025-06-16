<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Menghasilkan laporan penjualan lengkap untuk rentang tanggal tertentu.
     * Fungsi ini mengambil semua order dalam rentang yang diberikan,
     * menghitung statistik utama, dan menemukan produk terlaris.
     *
     * @param Carbon $startDate Tanggal mulai periode laporan.
     * @param Carbon $endDate Tanggal akhir periode laporan.
     * @return array Mengembalikan array yang berisi data statistik dan daftar produk terlaris.
     */
    public function generateReport(Carbon $startDate, Carbon $endDate): array
    {
        // Ambil koleksi order dalam rentang tanggal yang ditentukan untuk kalkulasi.
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

        // Query untuk menemukan item terlaris dalam periode tersebut.
        // Ini menggabungkan OrderItem dengan tabel produk untuk mendapatkan nama produk.
        $topSellingItems = OrderItem::query()
            // Filter hanya untuk order item yang termasuk dalam order yang relevan.
            ->whereIn('order_id', $orders->pluck('id'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                // Hitung total kuantitas yang terjual untuk setiap produk.
                DB::raw('SUM(order_items.quantity) as total_quantity_sold'),
                // Hitung total pendapatan dari setiap produk.
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            // Kelompokkan hasil berdasarkan nama produk.
            ->groupBy('product_name')
            // Urutkan berdasarkan kuantitas terjual secara menurun.
            ->orderByDesc('total_quantity_sold')
            // Batasi hasil hanya untuk 10 produk teratas.
            ->limit(10)
            ->get()
            ->toArray(); // Konversi hasil ke array untuk konsistensi.

        // Kembalikan semua data laporan dalam satu array yang terstruktur.
        return [
            'stats' => [
                'total_revenue' => $orders->sum('total_price'),
                'total_transactions' => $orders->count(),
                'total_items_sold' => $orders->sum('total_item'),
            ],
            'top_selling_items' => $topSellingItems,
        ];
    }
}
