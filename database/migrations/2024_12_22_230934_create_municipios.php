<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_municipio', 100);
            $table->unsignedBigInteger('estado_id');       
            $table->timestamps();


            $table->foreign('estado_id')->references('id')->on('estados');

        });
    }

    public function down()
    {
        Schema::dropIfExists('municipios');
    }
};
