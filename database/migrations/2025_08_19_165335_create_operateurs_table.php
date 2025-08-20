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
        Schema::create('operateurs', function (Blueprint $table) {
            $table->id();
            //        'localite','nature','cause','prenom','nom','tel','superficie','financement','op','cout','commentaire','commune_id'
            $table->string('localite');
            $table->string('nature');
            $table->string('cause');
            $table->string('prenom');
            $table->string('nom');
            $table->string('tel');
            $table->string('superficie');
            $table->string('financement');
            $table->string('op');
            $table->string('cout');
            $table->string('commentaire')->nullable();
            $table->unsignedBigInteger('commune_id');
            $table->foreign('commune_id')->references('id')->on('communes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operateurs');
    }
};
