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
        Schema::create('stock_card', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->integer('price')->nullable();
            $table->string('reference')->nullable()->references('id')->on('delivery')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('mark_up_price')->nullable();
            $table->string('supplier')->nullable();
            $table->string('incharge')->nullable();
            $table->integer('balance')->nullable();
            $table->foreignId('products_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('stock_card');
    }
};