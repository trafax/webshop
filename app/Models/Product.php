<?php

namespace App\Models;

use App\Pivots\FilterProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    public $fillable = [
        'sku', 'title', 'description', 'price', 'seo', 'slug'
    ];

    public $translatable = [
        'title', 'description', 'slug'
    ];

    public $casts = [
        'seo' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function filters()
    {
        return $this->belongsToMany(Filter::class)->using(FilterProduct::class)->withPivot('id', 'title', 'price', 'price_extra');
    }
}
