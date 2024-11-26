<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Usuario que realizó la venta
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete(); // Cliente asociado a la venta
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('sale_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_product');
        Schema::dropIfExists('sales');
    }
}
