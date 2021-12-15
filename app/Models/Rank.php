<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{

    protected $table = 'ranks';
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

}
