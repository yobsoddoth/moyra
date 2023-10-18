<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('author_id')->references('id')->on('users');
            $table->timestamps();
        });
        Schema::create('books_i18n', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->references('id')->on('books');
            $table->foreignId('language_id')->references('id')->on('languages');
            $table->foreignUuid('creator_id')->references('id')->on('users');

            $table->string('title', 255);
            $table->text('annotation');
            $table->timestamps();
        });

        Schema::create('episodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->references('id')->on('books');

            $table->boolean('is_prologue')->default(false)->comment('First episode of the book');
            $table->string('summary', 255);
            $table->timestamps();
        });
        Schema::create('episodes_i18n', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('episode_id')->references('id')->on('episodes');
            $table->foreignId('language_id')->references('id')->on('languages');
            $table->foreignUuid('creator_id')->references('id')->on('users');

            $table->text('content');
            $table->timestamps();
        });

        Schema::create('choices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('episode_id')->references('id')->on('episodes');

            $table->foreignUuid('towards_episode_id')->references('id')->on('episodes');
            $table->string('summary', 255);
            $table->timestamps();
        });
        Schema::create('choices_i18n', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('choice_id')->references('id')->on('choices');
            $table->foreignId('language_id')->references('id')->on('languages');
            $table->foreignUuid('creator_id')->references('id')->on('users');

            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choices_i18n');
        Schema::dropIfExists('choices');

        Schema::dropIfExists('episodes_i18n');
        Schema::dropIfExists('episodes');

        Schema::dropIfExists('books_i18n');
        Schema::dropIfExists('books');

        Schema::dropIfExists('languages');
    }
};
