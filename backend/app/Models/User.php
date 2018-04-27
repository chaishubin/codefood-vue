<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $keyType = 'bigint';
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function manyCollection()
    {
        return $this->hasMany('App\Models\UserCollection','user_id','id');
    }
}
