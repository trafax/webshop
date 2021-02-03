<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public $fillable = [
        'file',
        'parent_id',
        'module',
        'file_data'
    ];

    public $casts = [
        'file_data' => 'array'
    ];
}
