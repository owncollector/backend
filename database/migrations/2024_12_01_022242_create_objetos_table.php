<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class CreateObjetosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetos', function (Blueprint $table) {
            $table->id(); // Campo ID del objeto
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Campo user_id como clave foránea
            $table->string('nombre'); // Campo para almacenar el nombre del objeto
            $table->double('valor'); // Campo para almacenar el valor del objeto (ajusta el tamaño según sea necesario)
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objetos');
    }
}
