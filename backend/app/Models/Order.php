<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $keyType = 'bigint';
    public $incrementing = false;
    protected $primaryKey = 'id';
}
