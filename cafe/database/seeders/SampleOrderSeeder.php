<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Table;

class SampleOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create sample table
        $table = Table::firstOrCreate(
            ['nomor_meja' => 1],
            [
                'kapasitas' => 4,
                'status' => 'available',
                'qr_code' => 'QR-TABLE-001',
            ]
        );

        // Sample orders data
        $orders = [
            [
                'kode_order' => 'ORD-136',
                'nama_pemesan' => 'Fadhil',
                'status' => 'completed',
                'status_bayar' => 'paid',
                'metode_pembayaran' => 'qris',
                'total_harga' => 47000,
                'items' => [
                    ['product_id' => 1, 'quantity' => 2, 'harga_satuan' => 17000], // Es Kopi Susu
                    ['product_id' => 4, 'quantity' => 1, 'harga_satuan' => 13000], // Additional item
                ]
            ],
            [
                'kode_order' => 'ORD-126',
                'nama_pemesan' => 'Galang',
                'status' => 'pending',
                'status_bayar' => 'unpaid',
                'metode_pembayaran' => 'cash',
                'total_harga' => 20000,
                'items' => [
                    ['product_id' => 3, 'quantity' => 1, 'harga_satuan' => 20000], // Nasi Goreng Cikur
                ]
            ],
            [
                'kode_order' => 'ORD-135',
                'nama_pemesan' => 'Fadhil',
                'status' => 'completed',
                'status_bayar' => 'paid',
                'metode_pembayaran' => 'qris',
                'total_harga' => 15000,
                'items' => [
                    ['product_id' => 6, 'quantity' => 1, 'harga_satuan' => 15000], // Tahu Lada Garam
                ]
            ],
            [
                'kode_order' => 'ORD-134',
                'nama_pemesan' => 'Fadhil',
                'status' => 'processing',
                'status_bayar' => 'paid',
                'metode_pembayaran' => 'cash',
                'total_harga' => 32000,
                'items' => [
                    ['product_id' => 2, 'quantity' => 2, 'harga_satuan' => 8000], // Donat Kampoeng
                    ['product_id' => 1, 'quantity' => 1, 'harga_satuan' => 16000], // Es Kopi Susu
                ]
            ],
            [
                'kode_order' => 'ORD-195',
                'nama_pemesan' => 'Customer Test',
                'status' => 'completed',
                'status_bayar' => 'paid',
                'metode_pembayaran' => 'qris',
                'total_harga' => 47000,
                'items' => [
                    ['product_id' => 5, 'quantity' => 1, 'harga_satuan' => 22000], // Caffe Latte
                    ['product_id' => 4, 'quantity' => 1, 'harga_satuan' => 25000], // Matcha Latte
                ]
            ],
            [
                'kode_order' => 'ORD-196',
                'nama_pemesan' => 'Customer Test',
                'status' => 'completed',
                'status_bayar' => 'paid',
                'metode_pembayaran' => 'qris',
                'total_harga' => 20000,
                'items' => [
                    ['product_id' => 3, 'quantity' => 1, 'harga_satuan' => 20000], // Nasi Goreng Cikur
                ]
            ],
        ];

        foreach ($orders as $orderData) {
            $items = $orderData['items'];
            unset($orderData['items']);

            // Calculate subtotal
            $subtotal = collect($items)->sum(function ($item) {
                return $item['quantity'] * $item['harga_satuan'];
            });

            $order = Order::create([
                'table_id' => $table->id,
                'subtotal' => $subtotal,
                'service_fee' => 0,
                'created_at' => now()->subDays(rand(0, 7)),
                'updated_at' => now()->subDays(rand(0, 7)),
                ...$orderData
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['harga_satuan'],
                ]);
            }
        }
    }
}
