<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'min_license',
        'min_license_name',
        'min_license_color',
        'category_id',
        'eligible',
        'name',
    ];

}
