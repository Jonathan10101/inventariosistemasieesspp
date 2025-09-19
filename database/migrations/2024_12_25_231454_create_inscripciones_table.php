<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();            
                        

            $table->unsignedBigInteger('estudiante_id');            
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('adscripcion_id');
            $table->unsignedBigInteger('sede_id');       
            $table->unsignedBigInteger('generacion_id')->default(1);   
            $table->date('fecha_inicio')->default('2000-01-01');  // Fecha en la que inicia el curso
            $table->date('fecha_fin')->default('2000-01-01');     // Fecha en la que termina el curso  
            $table->integer('promedio');      
            $table->date('fecha_validacion_inicial')->nullable(false); 
            $table->date('fecha_validacion_final')->nullable(false); 
            $table->date('fecha_de_ejecucion_inicial')->nullable(false);   
            $table->date('fecha_de_ejecucion_final')->nullable(false);       
    
            $table->timestamps();

            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->foreign('adscripcion_id')->references('id')->on('adscripciones');            
            $table->foreign('sede_id')->references('id')->on('sedes');               
            $table->foreign('generacion_id')->references('id')->on('generaciones');         
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscripciones');
    }
};
