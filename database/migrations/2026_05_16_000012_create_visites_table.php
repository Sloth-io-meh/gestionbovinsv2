<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visites', function (Blueprint $table) {
            $table->id('id_pres');
            $table->text('description_v')->nullable();
            $table->date('datepres')->nullable();
            $table->float('prix_pres')->nullable();
            $table->unsignedBigInteger('id_bov')->nullable();
            $table->string('id_vet', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_bov')->references('id_bov')->on('bovins')->onDelete('set null');
            $table->foreign('id_vet')->references('id_vet')->on('vetos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
