<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('nama', 150);
            $table->string('slug', 150)->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2);
            $table->string('foto')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('stock')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('category_id');
            $table->index('is_available');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};