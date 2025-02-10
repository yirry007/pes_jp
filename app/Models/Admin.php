<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use HasApiTokens;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;
}
