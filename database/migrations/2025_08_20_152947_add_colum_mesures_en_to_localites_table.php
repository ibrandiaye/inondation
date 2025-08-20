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
        Schema::table('localites', function (Blueprint $table) {
            $table->text('mesure')->change();
            $table->text('attention')->change();
            $table->text('solution')->change();
            $table->text('besoin')->change();
            $table->text('commentaire')->nullable()->change();
            $table->text('mesureen');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('localites', function (Blueprint $table) {
            $table->string('mesure')->change();
            $table->string('attention')->change();
            $table->string('solution')->change();
            $table->string('besoin')->change();
            $table->string('commentaire')->nullable()->change();
            $table->dropColumn('mesureen');
        });
    }
};
