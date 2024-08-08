<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Langs extends Model
{
    use HasFactory;
    protected $table = 'blog_langs';
    protected $fillable = ['blog_id','slug','name','lang','content','title','description'];

    public $timestamps = false;

}
