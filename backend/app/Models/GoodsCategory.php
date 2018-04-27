<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    protected $table = 'goods_category';
    protected $keyType = 'bigint';
    public $incrementing = false;
    protected $primaryKey = 'category_id';


    public function goods()
    {
        return $this->hasMany('App\Models\Goods','goods_id','category_id');
    }
}
