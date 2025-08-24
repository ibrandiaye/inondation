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
        Schema::table('operateurs', function (Blueprint $table) {
            $table->unsignedBigInteger("localite_id")->nullable();
            $table->foreign("localite_id")->references("id")->on("localites")->onDelete("cascade")->onUpdate("cascade");
            $table->string("doc")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operateurs', function (Blueprint $table) {
            $table->dropForeign(["localite_id"]);
            $table->dropColumn("localite_id");
            $table->dropColumn("doc");

        });
    }
};
