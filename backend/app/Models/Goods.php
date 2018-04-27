<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $keyType = 'bigint';
    public $incrementing = false;
    protected $primaryKey = 'goods_id';

    public function goodsCategory()
    {
        return $this->belongsTo('App\Models\GoodsCategory','category_id','goods_id');
    }
}
