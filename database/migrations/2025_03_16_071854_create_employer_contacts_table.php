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
        Schema::create('employer_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employer_id')->nullable();
            $table->string('contact_person', 200)->nullable();
            $table->string('mobile_code', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('alternate_mobile_code', 10)->nullable();
            $table->string('alternate_mobile', 20)->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_contacts');
    }
};
