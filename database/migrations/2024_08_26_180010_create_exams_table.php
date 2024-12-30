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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('exam_body_id');
			$table->string('name');
			$table->string('abbr');
			$table->unsignedTinyInteger('month')->index();
			$table->year('year')->index();
			$table->string('type');
			$table->text('description')->nullable();
			$table->string('remarks')->nullable();
			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
