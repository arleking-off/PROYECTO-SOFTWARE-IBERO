<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('nit')->nullable();
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->foreignId('user_id')->constrained('users')->comment('Propietario principal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiendas');
    }
};
