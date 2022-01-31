<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCommentsTableAddColumnArticleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
           $table->foreignUuid('comment_eval_id')
               ->nullable()
               ->comment('Replay to another comment')
               ->after('article_eval_id')
               ->constrained('comments', 'eval_id')
               ->cascadeOnUpdate()
               ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('comments',
            ['comment_eval_id']);
    }
}
