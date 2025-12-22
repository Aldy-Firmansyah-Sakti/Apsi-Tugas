<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('metode', ['cash', 'qris']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->text('qris_url')->nullable();
            $table->text('response_data')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};