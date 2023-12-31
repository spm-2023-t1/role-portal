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
        Schema::create('jobs', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('role_name');
            $table->string('description');
            $table->string('role_type');
            $table->string('listing_status');
            $table->datetime('deadline');
            $table->datetime('role_listing_open');
            $table->foreignId('owner_id')->nullable()->references('id')->on('users');
            $table->foreignId('source_manager_id')->references('id')->on('users');
            $table->foreignId('update_user_id')->nullable()->references('id')->on('users');
            $table->string('is_released');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
