<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendeurs', function (Blueprint $table) {
            $table->id('id_vend');
            $table->string('nom_vend', 25)->nullable();
            $table->string('prenom_vend', 25)->nullable();
            $table->string('tel_vend', 25)->nullable();
            $table->string('farm_vend', 25)->nullable();
            $table->unsignedBigInteger('id_bov')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendeurs');
    }
};
