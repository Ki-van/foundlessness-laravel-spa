<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id', 'comment_id'];
    protected $casts = [
        'created_at' => 'datetime:y-m-d hh:mm',
        'updated_at' => 'datetime:Y-m-d hh:mm',
    ];
    protected $table = 'comments';
    protected $primaryKey = 'id';

    public function marks() {
        return $this->morphMany(Mark::class, 'markable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id')
            ->with('replies');
    }
}
