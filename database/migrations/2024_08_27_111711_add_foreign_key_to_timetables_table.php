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
        Schema::table('timetables', function (Blueprint $table) {
            $table->foreign(['exam_id'])->references(['id'])->on('exams')->cascadeOnUpdate();
            $table->foreign(['paper_type_id'])->references(['id'])->on('paper_types')->cascadeOnUpdate();
            $table->foreign(['subject_id'])->references(['id'])->on('subjects')->cascadeOnUpdate();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropForeign('timetables_exam_id_foreign');
            $table->dropForeign('timetables_paper_type_id_foreign');
            $table->dropForeign('timetables_subject_id_foreign');
           
        });
    }
};
