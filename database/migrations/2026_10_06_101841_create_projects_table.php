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
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('excerpt');
            $table->longText('description');
            $table->string('thumbnail_url')->nullable();
            $table->string('banner_image_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('client_name')->nullable();
            $table->string('timeline')->nullable();
            $table->date('completed_at')->nullable();
            $table->json('tech_stack');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
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