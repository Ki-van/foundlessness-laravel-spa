<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $primaryKey = 'eval_id';
    protected $fillable = ['heading', 'description', 'body', 'slug'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->whereNull('comment_id');
    }
    public function marks() {
        return $this->morphMany(Mark::class, 'markabke');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function status()
    {
        return $this->belongsTo(ArticleStatus::class, 'article_status_id');
    }

    public function tags()
    {
        $this->belongsToMany(Tag::class,
            'article_tag',
            'article_id',
        'tag_id');
    }
}
