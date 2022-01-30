<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsAndTagsArticleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('user_id')
                ->nullable()
                ->comment('Author id')
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
        Schema::create('article_tag', function (Blueprint $table) {
           $table->foreignUuid('article_eval_id')
               ->constrained('articles', 'eval_id')
               ->cascadeOnDelete()
               ->cascadeOnUpdate();
           $table->foreignId('tag_id')
               ->constrained('tags')
               ->restrictOnDelete()
               ->cascadeOnUpdate();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
