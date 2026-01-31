<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable()->default('admin');
            $table->string('username', 100)->nullable()->default('admin');
            $table->string('password', 100)->nullable()->default('admin');
            $table->rememberToken();
            $table->bigInteger('mobile')->nullable()->default(0);
            $table->string('mail_id', 100)->nullable()->default('admin@gmail.com');
            $table->string('profile_image', 100)->nullable();
            $table->string('department', 1000)->nullable();
            $table->integer('user_type')->nullable();
            $table->timestamps();
        });

        DB::table('admin_details')->insert([

            'name'=>'admin',
            'username'=>'admin',
            'password'=>bcrypt('admin'),

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_details');
    }
};
