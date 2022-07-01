<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'license_group',
        'season_id',
        'season_year',
        'season_quarter',
        'race_week_num',
        'track_id',
        'track_name',
        'config_name',
        'current_week'
    ];
}
