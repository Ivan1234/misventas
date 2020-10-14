<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idcategoria');
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 100)->unique();
            $table->decimal('precio_venta',11,2);
            $table->integer('stock');
            $table->boolean('condicion')->default(1);
            $table->timestamps();

            $table->foreign('idcategoria')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
