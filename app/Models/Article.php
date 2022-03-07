<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'article_status_id', 'domain_id', 'user_id'];
    protected $casts = [
        'body' => 'array',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

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
        return $this->belongsToMany(Tag::class,'article_tag','article_id','tag_id');
    }
    public function versions()
    {
        return $this->hasMany(Version::class, 'article_id');
    }

    public function latestVersion()
    {
        return $this->versions()
            ->where('version_status_id', ArticleStatus::PUBLISHED_ID)
            ->get()
            ->sort(function($a, $b){
            if($a->semver->gt($b->semver))
                return -1;
            elseif ($b->semver->gt($a->semver))
                return 1;
            else
                return 0;
        })->first->toArray();
    }
}
