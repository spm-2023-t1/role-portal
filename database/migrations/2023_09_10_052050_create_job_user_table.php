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
        Schema::create('job_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id');
            $table->foreignId('user_id');
            $table->date('start_date')->nullable(); //added
            $table->string('remarks', 500)->nullable(); //added
            $table->enum('role_app_status', ['applied', 'withdrawn']); //added
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_user');
    }
};
