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
        Schema::table('syllabi', function (Blueprint $table) {
            $table->foreign(['exam_body_id'])->references(['id'])->on('exam_bodies')->cascadeOnUpdate();
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->cascadeOnUpdate();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('syllabi', function (Blueprint $table) {
            $table->dropForeign('syllabi_exam_body_id_foreign');
            $table->dropForeign('syllabi_subject_id_foreign');
            
        });
    }
};
