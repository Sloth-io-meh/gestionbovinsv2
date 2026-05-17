<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bovins', function (Blueprint $table) {
            $table->unsignedBigInteger('id_trans')->nullable()->after('id_q');
            $table->unsignedBigInteger('id_veh')->nullable()->after('id_trans');

            $table->foreign('id_trans')->references('id_trans')->on('tansporteurs')->onDelete('set null');
            $table->foreign('id_veh')->references('id_veh')->on('vehicules')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('bovins', function (Blueprint $table) {
            $table->dropForeign(['id_trans']);
            $table->dropForeign(['id_veh']);
            $table->dropColumn(['id_trans', 'id_veh']);
        });
    }
};
