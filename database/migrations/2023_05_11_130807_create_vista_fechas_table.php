<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVistaFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vista_fechas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("faq_id");
            $table->bigInteger("vistas");
            $table->date("fecha");
            $table->timestamps();

            $table->foreign("faq_id")->on("faqs")->references("id")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vista_fechas');
    }
}
