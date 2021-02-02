<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = [
        'title', 'description', 'slug'
    ];

    public $fillable = [
        'parent_id', 'title', 'description', 'slug', 'seo', 'sort'
    ];

    public $casts = [
        'seo' => 'array'
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('sort');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
