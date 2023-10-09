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
            // $table->datetime('date_of_creation')->timestamps();
            $table->timestamp('date_of_creation')->useCurrent();
            $table->datetime('deadline');
            $table->foreignId('user_id');
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
