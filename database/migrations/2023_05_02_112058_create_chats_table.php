<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("visitante_id");
            $table->unsignedBigInteger("emisor_id")->nullable();
            $table->unsignedBigInteger("receptor_id")->nullable();
            $table->text("mensaje");
            $table->date("fecha");
            $table->time("hora");
            $table->string("estado");
            $table->timestamps();

            $table->foreign("visitante_id")->on("visitantes")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
