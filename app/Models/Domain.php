<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $fillable = ['id','name', 'description'];
    protected $table = 'domains';
    protected $keyType = 'string';

    public function articles()
    {
       return $this->hasMany(Article::class, 'domain_id');
    }

}
