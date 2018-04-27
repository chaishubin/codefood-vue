<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_category', function (Blueprint $table) {
            $table->bigInteger('category_id')->comment('分类id');
            $table->bigInteger('parent_id')->comment('父id');
            $table->string('parent_id_path',128)->comment('家族图谱');
            $table->bigInteger('seller_id')->comment('商家id');
            $table->string('category_name',100)->comment('分类名称');
            $table->string('category_img',400)->comment('分类图片');
            $table->tinyInteger('status')->comment('状态');
            $table->tinyInteger('sort')->comment('排序');
            $table->primary('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_category');
    }
}
