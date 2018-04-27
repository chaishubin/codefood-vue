<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCollection extends Model
{
    protected $table = 'user_collection';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User','id','user_id');
    }
}
