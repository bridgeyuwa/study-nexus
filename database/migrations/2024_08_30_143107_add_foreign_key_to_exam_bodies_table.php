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
        Schema::table('exam_bodies', function (Blueprint $table) {
           $table->foreign(['state_id'])->references(['id'])->on('states')->cascadeOnUpdate();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_bodies', function (Blueprint $table) {
            $table->dropForeign('exam_bodies_state_id_foreign');
           
        });
    }
};
