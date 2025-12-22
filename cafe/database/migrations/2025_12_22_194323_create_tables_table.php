<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meja', 10)->unique();
            $table->text('qr_code');
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->integer('kapasitas')->default(4);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('nomor_meja');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};