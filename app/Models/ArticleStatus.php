<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleStatus extends Model
{
    public const PUBLISHED_ID = 1;
    public const MODERATED_ID = 2;
    protected $table = 'article_statuses';

    use HasFactory;

    protected $fillable = ['status'];
}
