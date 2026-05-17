<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify existing users table created by Laravel scaffolding
        Schema::table('users', function (Blueprint $table) {
            // Add our custom fields if they don't exist
            if (!Schema::hasColumn('users', 'nom')) {
                $table->string('nom', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'adresse')) {
                $table->string('adresse', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'ville')) {
                $table->string('ville', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'code')) {
                $table->string('code', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'tel')) {
                $table->string('tel', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['nom', 'prenom', 'adresse', 'ville', 'code', 'tel']);
        });
    }
};

