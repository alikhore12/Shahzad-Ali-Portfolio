<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->string('category');
            $table->text('description'); $table->longText('body')->nullable(); $table->json('tags')->nullable();
            $table->json('features')->nullable(); $table->string('accent')->default('coral'); $table->string('year', 4)->nullable();
            $table->boolean('published')->default(true); $table->timestamps();
        });
        Schema::create('portfolio_skills', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->string('category');
            $table->text('intro'); $table->text('details')->nullable(); $table->json('points')->nullable();
            $table->boolean('published')->default(true); $table->timestamps();
        });
        Schema::create('portfolio_services', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->text('intro');
            $table->text('details')->nullable(); $table->json('points')->nullable(); $table->boolean('published')->default(true); $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_services'); Schema::dropIfExists('portfolio_skills'); Schema::dropIfExists('portfolio_projects');
    }
};
