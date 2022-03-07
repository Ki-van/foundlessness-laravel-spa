<?php

namespace App\Models;

use App\Casts\SemVer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    use HasFactory;
    protected $fillable = ['article_id', 'heading', 'description', 'body', 'version_status_id', 'semver'];
    protected $casts = [
        'body' => 'array',
        'semver' => SemVer::class,
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

    public function status()
    {
        return $this->belongsTo(ArticleStatus::class, 'version_status_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

}
