<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'seller';
    protected $keyType = 'bigint';
    public $incrementing = false;
    protected $primaryKey = 'id';
}
