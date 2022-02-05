<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $fillable = ['slug', 'name', 'description'];

    public function articles()
    {
        $this->hasMany(Article::class, 'domain_id');
    }

}
