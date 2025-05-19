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
        Schema::create('project_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('project_id')->nullable();
            $table->dateTime('time')->nullable();
            $table->string('status')->nullable();
            $table->string('meeting_type')->nullable();
            $table->text('agenda')->nullable();
            $table->string('link')->nullable();
            $table->timestamp('timestamp_created')->nullable();
            $table->timestamp('timestamp_meeting')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_meetings');
    }
};
