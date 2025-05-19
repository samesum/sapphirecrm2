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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('category_id')->nullable();
            $table->string('client')->nullable();
            $table->string('staffs')->nullable();
            $table->string('budget')->nullable();
            $table->string('progress_status')->nullable();
            $table->string('status')->nullable();
            $table->longText('note')->nullable();
            $table->string('privacy')->nullable();
            $table->timestamp('timestamp_start')->nullable();
            $table->timestamp('timestamp_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
