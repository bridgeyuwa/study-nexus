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
        Schema::create('institutions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('former_name')->nullable();
            $table->string('abbr')->nullable();
            $table->text('description')->nullable();
            $table->year('established')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->string('locality')->nullable();
			$table->string('parent_id')->nullable();
            $table->unsignedBigInteger('institution_type_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('term_id');
			$table->unsignedBigInteger('accreditation_body_id');
			$table->unsignedBigInteger('accreditation_status_id');
			$table->unsignedBigInteger('religious_affiliation_id');
			$table->string('slogan')->nullable();
            $table->string('address')->nullable();
            $table->json('coordinates')->nullable();
            $table->string('url')->nullable();
			$table->string('alt_url')->nullable();
			$table->string('logo')->nullable();
			$table->integer('postal_code')->nullable();
			
            $table->string('email')->nullable();
            $table->integer('rank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
