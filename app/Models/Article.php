<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'domain_id', 'user_id'];
    protected $casts = [
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

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'article_tag','article_id','tag_id');
    }
    public function versions()
    {
        return $this->hasMany(Version::class, 'article_id');
    }

    public function latestVersion($version_status = ArticleStatus::PUBLISHED_ID)
    {
        $versions = null;
        if($version_status)
            $versions = $this->versions()
                ->where('version_status_id', $version_status)
                ->get();
        else
            $versions = $this->versions;

        return $versions
            ->sort(function($a, $b){
            if($a->semver->gt($b->semver))
                return -1;
            elseif ($b->semver->gt($a->semver))
                return 1;
            else
                return 0;
        })->first->toArray();
    }

    public function hasPublicVersions(): bool
    {
        return $this->versions()->where('version_status_id', ArticleStatus::PUBLISHED_ID)->exists();
    }
}
