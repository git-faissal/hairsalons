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
        Schema::create('table_reservation', function (Blueprint $table) {
            $table->id();
            $table->string('categorie');
            $table->string('specialiste')->nullable();
            $table->date('date');
            $table->string('prix');
            $table->string('heure');
            /**
             * Migration cle etrangere table utilisateur
             */
            $table->foreignId('user_id')->constrained(
                table: 'users'
            );
            $table->timestamps();
             /**
             * Activation des cles etrangeres
             */
            
             Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_reservation');
    }
};
