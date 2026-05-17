<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nourriture', function (Blueprint $table) {
            $table->id('id_n');
            $table->string('libelle_n', 25)->nullable();
            $table->string('quantite_n', 25)->nullable();
            $table->float('prix')->nullable();
            $table->unsignedBigInteger('id_bov');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_bov')->references('id_bov')->on('bovins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nourriture');
    }
};
