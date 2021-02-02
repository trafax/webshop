<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Translatable\HasTranslations;

class FilterProduct extends Pivot
{
    use HasFactory, HasTranslations;

    public $table = 'filter_product';

    public $timestamps = false;

    public $fillable = [
        'title', 'price', 'price_extra'
    ];

    public $translatable = [
        'title'
    ];
}
