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
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->enum('status', ['open', 'closed']);
            // $table->enum('role_type', ['permanent', 'temporary']);
            // $table->enum('flags', ['Open', 'Private', 'Closed']);
            $table->string('role_type');
            $table->string('flags');
            $table->timestamp('deadline');
            $table->foreignId('user_id');
            // $table->string('created_by')->nullable();
            // $table->string('updated_by')->nullable();
            $table->timestamps();

            // $table->foreign('created_by')->references('name')->on('users');
            // $table->foreign('updated_by')->references('name')->on('users');
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
