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
        Schema::create('institution_program', function (Blueprint $table) {
			$table->id();
            $table->string('institution_id');
            $table->string('program_id');
            $table->unsignedBigInteger('level_id');
			$table->string('name')->nullable();
            $table->text('description')->nullable();
			$table->text('remarks')->nullable();
			$table->unsignedBigInteger('program_mode_id')->nullable();
            $table->string('duration')->nullable();
            $table->integer('tuition_fee')->nullable();
            $table->integer('utme_cutoff')->nullable();
            $table->json('requirements')->nullable();
			$table->text('direct_entry')->nullable();
			$table->text('o_level')->nullable();
			$table->text('utme_subjects')->nullable();
			$table->unsignedBigInteger('accreditation_body_id');
			$table->unsignedBigInteger('accreditation_status_id')->nullable();
			$table->boolean('is_distinguished')->default(0);
			$table->date('accreditation_grant_date')->nullable();
			$table->date('accreditation_expiry_date')->nullable();
			
            $table->timestamps();

            $table->unique(['institution_id', 'program_id', 'level_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_program');
    }
};
