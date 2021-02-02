<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Filter extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $translatable = [
        'title', 'slug'
    ];

    public $fillable = [
        'title', 'required', 'multiple', 'selectable', 'sort', 'slug'
    ];

    public function options()
    {
        return $this->hasMany(Filter_product::class);
    }
}
