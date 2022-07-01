<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'name',
        'ir',
        'sr',
        'licenses'
    ];

    public function decodeValues()
    {
        $this->ir = json_decode($this->ir, true);
        $this->sr = json_decode($this->sr, true);
        $this->licenses = json_decode($this->licenses, true);
    }
}
