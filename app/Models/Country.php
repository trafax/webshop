<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $fillable = [
        'title', 'iso', 'eu', 'sort'
    ];

    public $translatable = [
        'title'
    ];
}
