<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Mark;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'User']);

        Article::factory(10)
            ->has(Comment::factory(3)
                ->has(Comment::factory(2)->hasReplies(1), 'replies'))
            ->has(Tag::factory(4))
            ->has(Mark::factory(7))
            ->create();

        /**
         * @var $user User
         */
        $user = User::factory()
            ->has(Article::factory(3))->create([
            'name' => 'kivan',
            'email'=>'kirill.ivanin00@yandex.ru',
            'password' => Hash::make('kivan',),
            'remember_token'=>null
        ]);

        $user->assignRole('Admin');
    }
}
