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
        Schema::table('level_program', function (Blueprint $table) {
            $table->foreign(['level_id'])->references(['id'])->on('levels')->cascadeOnUpdate();
            $table->foreign(['program_id'])->references(['id'])->on('programs')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('level_program', function (Blueprint $table) {
            $table->dropForeign('level_program_level_id_foreign');
            $table->dropForeign('level_program_program_id_foreign');
        });
    }
};
