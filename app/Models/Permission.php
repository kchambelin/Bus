<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'idpermission';
    public $timestamps = false;

    public function rank() {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    public function operation() {
        return $this->belongsTo(Operation::class, 'operation_id');
    }
}
