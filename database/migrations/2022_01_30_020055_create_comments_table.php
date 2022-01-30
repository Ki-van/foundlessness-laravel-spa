<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->foreignUuid('eval_id')
                ->primary()
                ->unique()
                ->constrained('evaluables')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->string('body', 2048);
            $table->foreignId('user_id')
                ->comment('Author id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
           /* $table->foreignUuid('comment_eval_id')
                ->comment('Replay')
                ->nullable()
                ->constrained('comments', 'eval_id')
                ->restrictOnDelete()
                ->cascadeOnUpdate();*/
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
        Schema::dropIfExists('comments');
    }
}
