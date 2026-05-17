<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meds', function (Blueprint $table) {
            $table->id('id_med');
            $table->string('libelle', 25)->nullable();
            $table->string('description', 250)->nullable();
            $table->float('quantite_med')->nullable();
            $table->float('prix_med')->nullable();
            $table->date('dateachat')->nullable();
            $table->date('dateexp_med')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meds');
    }
};
