<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'idoperation';
    public $timestamps = false;
}
