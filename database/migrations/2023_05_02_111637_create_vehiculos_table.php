<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("marca_id");
            $table->unsignedBigInteger("tipo_id");
            $table->unsignedBigInteger("anio_id");
            $table->unsignedBigInteger("modelo_id");
            $table->text("descripcion");
            $table->string("imagen")->nullable();
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("marca_id")->on("marcas")->references("id");
            $table->foreign("tipo_id")->on("tipos")->references("id");
            $table->foreign("anio_id")->on("anios")->references("id");
            $table->foreign("modelo_id")->on("modelos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
