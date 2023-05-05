<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vehiculo_id");
            $table->unsignedBigInteger("caracteristica_id");
            $table->longText("pregunta");
            $table->longText("respuesta");
            $table->date("fecha_registro");
            $table->timestamps();
            $table->foreign("vehiculo_id")->on("vehiculos")->references("id");
            $table->foreign("caracteristica_id")->on("caracteristica_vehiculos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}
