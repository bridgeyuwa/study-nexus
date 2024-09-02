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
        Schema::create('exam_bodies', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('abbr');
			$table->text('description')->nullable();
			
			$table->unsignedBiginteger('state_id');
			$table->string('address');
			$table->string('locality');
			$table->integer('postal_code')->nullable();
			
			
			$table->string('url')->nullable();
			$table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_bodies');
    }
};
