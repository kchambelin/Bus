<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'idtoken';
    public $timestamps = false;

    public function login() {
        return $this->belongsTo(Users::class, 'iduser');
    }
}
