<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateArticlesEvSetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('article_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status', 32);
        });

        Schema::create('domains', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('description');
            $table->string('name');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->comment('Author id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('domain_id');
            $table->foreign('domain_id')
                ->references('id')
                ->on('domains')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('slug', 63)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
                ->comment('Version-able article')
                ->constrained('articles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('version_status_id')
                ->constrained('article_statuses')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('heading', 255);
            $table->string('description', 511);
            $table->jsonb('body');
            $table->string('semver');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versions');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('domains');
        Schema::dropIfExists('article_statuses');
    }
}
