<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order', 20)->unique();
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->string('nama_pemesan', 100);
            $table->enum('status', [
                'pending', 
                'confirmed', 
                'processing', 
                'ready',
                'delivered', 
                'completed',
                'cancelled'
            ])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['cash', 'qris'])->nullable();
            $table->enum('status_bayar', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('kode_order');
            $table->index('table_id');
            $table->index('status');
            $table->index('status_bayar');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};