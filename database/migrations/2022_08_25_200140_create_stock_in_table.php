<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_in', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->integer('stock_in_qty')->nullable();
            $table->float('price')->nullable();
            $table->foreignId('products_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('supplier_id')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_in');
    }
};
