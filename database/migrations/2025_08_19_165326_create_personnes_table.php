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
        Schema::create('personnes', function (Blueprint $table) {
            $table->id();
            // 'localite','nature','cause','prenom','nom','tel','cni','besoin','commentaire','commune_id'
            $table->string('localite');
            $table->string('nature');
            $table->string('cause');
            $table->string('prenom');
            $table->string('nom');
            $table->string('tel');
            $table->string('cni');
            $table->string('besoin');
            $table->string('commentaire')->nullable();
            $table->unsignedBigInteger('commune_id');
            $table->foreign('commune_id')->references('id')->on('communes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnes');
    }
};
