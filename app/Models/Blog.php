<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['status','featured_image','slug','author_id','category_id','published_at'];

    public function contentsAZ()
    {
        return $this->hasOne(Blog_Langs::class, 'blog_id')->where('lang', 'az');
    }

    public function contentsEN()
    {
        return $this->hasOne(Blog_Langs::class, 'blog_id')->where('lang', 'en');
    }

    public function contentsRU()
    {
        return $this->hasOne(Blog_Langs::class, 'blog_id')->where('lang', 'ru');
    }

    public function allContents()
    {
        return [
            'az' => $this->contentsAZ()->first(),
            'en' => $this->contentsEN()->first(),
            'ru' => $this->contentsRU()->first(),
        ];
    }


    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'category_id');
    }
}
