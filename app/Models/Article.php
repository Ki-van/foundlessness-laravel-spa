<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['heading', 'description', 'body', 'slug', 'article_status_id', 'domain_slug', 'user_id'];
    protected $casts = [
        'body' => 'array',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function marks() {
        return $this->morphMany(Mark::class, 'markable');
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
       return $this->belongsToMany('App\Models\Tag','article_tag','article_id','tag_id');
    }
}
