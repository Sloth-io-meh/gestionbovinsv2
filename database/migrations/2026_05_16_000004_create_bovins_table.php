<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bovins', function (Blueprint $table) {
            $table->id('id_bov');
            $table->string('race', 25)->nullable();
            $table->date('dateachat')->nullable();
            $table->float('prixachat')->nullable();
            $table->float('poidachat')->nullable();
            $table->string('lieuachat', 25)->nullable();
            $table->date('datevente')->nullable();
            $table->float('prixavente')->nullable();
            $table->float('poidvente')->nullable();
            $table->string('lieuvente', 25)->nullable();
            $table->boolean('vendu')->default(false);
            $table->boolean('mort')->default(false);
            $table->date('datemort')->nullable();
            $table->unsignedBigInteger('id_etab')->nullable();
            $table->unsignedBigInteger('id_vend')->nullable();
            $table->unsignedBigInteger('id_q')->nullable();
            $table->float('poidAct')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('id_etab')->references('id_etab')->on('etables')->onDelete('set null');
            $table->foreign('id_vend')->references('id_vend')->on('vendeurs')->onDelete('set null');
            $table->foreign('id_q')->references('id_q')->on('quarantaines')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bovins');
    }
};
