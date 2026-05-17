<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id('id_veh');
            $table->string('Matricule', 25)->nullable();
            $table->string('type', 25)->nullable();
            $table->unsignedBigInteger('id_trans')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_trans')->references('id_trans')->on('tansporteurs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
