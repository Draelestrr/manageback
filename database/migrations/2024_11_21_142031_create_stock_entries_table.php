<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('purchase_price', 10, 2)->nullable(); // Precio de compra actualizado
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Usuario que registró la entrada
            $table->string('receipt_image_path')->nullable(); // Imagen del comprobante
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_entries');
    }
}
