<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idcompra');
            $table->foreign('idcompra')->references('id')->on('compras')->onDelete('cascade');
            $table->unsignedBigInteger('idproducto');
            $table->foreign('idproducto')->references('id')->on('products');
            $table->bigInteger('cantidad');
            $table->decimal('precio', 11, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_compras');
    }
}
