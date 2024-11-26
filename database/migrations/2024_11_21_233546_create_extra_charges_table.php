<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraChargesTable extends Migration
{
    public function up()
    {
        Schema::create('extra_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained()->cascadeOnDelete(); // Relación con el gasto
            $table->string('description'); // Descripción del cargo adicional
            $table->decimal('amount', 10, 2); // Monto del cargo adicional
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('extra_charges');
    }
}
