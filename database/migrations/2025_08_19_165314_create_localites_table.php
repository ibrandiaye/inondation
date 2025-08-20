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
        Schema::create('localites', function (Blueprint $table) {
            $table->id();
            // 'localite','nature','cause','mesure','attention','solution','besoin','commentaire','commune_id'
            $table->string('localite');
            $table->string('nature');
            $table->string('cause');
            $table->string('mesure');
            $table->string('attention');
            $table->string('solution');
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
        Schema::dropIfExists('localites');
    }
};
