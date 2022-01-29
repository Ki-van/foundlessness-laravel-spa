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
        Schema::create('evaluables', function (Blueprint $table){
           $table->uuid('id')->primary()->default(new Expression('gen_random_uuid()'));
        });

        Schema::create('article_statuses', function (Blueprint $table){
            $table->smallInteger('id')->primary();
            $table->string('status', 32);
        });

        Schema::create('domains', function (Blueprint $table){
            $table->smallInteger('id')->primary();
            $table->string('slug');
            $table->string('description');
            $table->string('name');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->foreignUuid('eval_id')->primary()->constrained('evaluables');
            $table->string('heading', 128);
            $table->string('description', 512);
            $table->jsonb('body');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('article_status_id')
                ->constrained('article_statuses')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('domain_id')
                ->constrained('domains')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('slug',128);
            $table->timestamps();
        });
        DB::raw(/** @lang PostgreSQL */'
        alter table articles alter created_at set default(localtimestamp(0));
        alter table articles alter updated_at set default(localtimestamp(0));
');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('domains');
        Schema::dropIfExists('article_statuses');
        Schema::dropIfExists('evaluables');
    }
}
