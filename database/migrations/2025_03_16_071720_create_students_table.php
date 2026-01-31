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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 200)->nullable();
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('mobile_code', 10)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('alternate_mobile_code', 10)->nullable();
            $table->string('alternate_mobile', 20)->nullable();
            $table->string('reg_num', 100)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('address', 1500)->nullable();
            $table->string('place', 500)->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('marital_status', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('qualification', 200)->nullable();
            $table->string('qualification_course', 200)->nullable();
            $table->integer('dept')->nullable();
            $table->string('course', 200)->nullable();
            $table->string('experience', 200)->nullable();
            $table->string('job_role', 200)->nullable();
            $table->string('behaviour_level', 20)->nullable();
            $table->string('skill_level', 20)->nullable();
            $table->string('lang_level', 20)->nullable(); 
            $table->string('status', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
