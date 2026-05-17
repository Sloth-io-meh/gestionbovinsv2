<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tansporteurs', function (Blueprint $table) {
            $table->id('id_trans');
            $table->string('cin_t', 10);
            $table->string('nom', 25)->nullable();
            $table->string('prenom', 25)->nullable();
            $table->string('tel', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tansporteurs');
    }
};
