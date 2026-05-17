<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('id_stock');
            $table->string('libelle_st', 25)->nullable();
            $table->string('description_s', 25)->nullable();
            $table->float('quantite_s')->nullable();
            $table->float('quantiteAct')->default(0);
            $table->float('prix_s')->nullable();
            $table->date('dateachat')->nullable();
            $table->date('dateexp_s')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
