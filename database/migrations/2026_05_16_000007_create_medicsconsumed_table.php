<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicsconsumed', function (Blueprint $table) {
            $table->id('id_m');
            $table->string('libelle_m', 50);
            $table->integer('quantite_m');
            $table->unsignedBigInteger('id_bov');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_bov')->references('id_bov')->on('bovins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicsconsumed');
    }
};
