<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->foreignId('tienda_id')->after('id')->constrained('tiendas')->onDelete('cascade');
        });
    }

    public function down():void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropForeign(['tienda_id']);
            $table->dropColumn('tienda_id');
        });
    }
};
