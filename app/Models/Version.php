<?php

namespace App\Models;

use App\Casts\SemVer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

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

    #[ArrayShape(['heading' => "string", 'description' => "string", 'body' => "string", 'article_id' => "string", 'version_type' => "array"])]
    public static function rules(): array
    {
        return [
            'heading' => 'required|max:255',
            'description' => 'required|min:20|max:511',
            'body' => 'required',
            'article_id' => 'required|exists:articles,id',
            'version_type' => ['required', Rule::in(['major', 'minor', 'patch'])],
        ];
    }

}
