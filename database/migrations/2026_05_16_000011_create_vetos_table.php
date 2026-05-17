<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vetos', function (Blueprint $table) {
            $table->string('id_vet', 25)->primary();
            $table->string('nom_vet', 25)->nullable();
            $table->string('prenom_vet', 25)->nullable();
            $table->string('tel_vet', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vetos');
    }
};
