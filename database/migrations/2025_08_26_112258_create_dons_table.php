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
        Schema::create('dons', function (Blueprint $table) {
            $table->id();
            $table->string('receptionniste');
            $table->string('nature');
            $table->string('valeur');
            $table->string('donneur');
            $table->date('date');
            $table->string('cause');
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->unsignedBigInteger('arrondissement_id')->nullable();
             $table->foreign("region_id")
            ->references("id")
            ->on("regions");
            $table->foreign("departement_id")
            ->references("id")
            ->on("departements");
             $table->foreign("arrondissement_id")
            ->references("id")
            ->on("arrondissements");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dons');
    }
};
