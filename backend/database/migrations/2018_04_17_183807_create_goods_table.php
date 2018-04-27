<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigInteger('goods_id');
            $table->bigInteger('category_id')->comment('分类id');
            $table->string('goods_name',100)->comment('产品名称');
            $table->string('goods_summary',100)->comment('产品简要');
            $table->decimal('sell_price',20,2)->comment('售价');
            $table->smallInteger('goods_tag')->comment('产品标签');
            $table->tinyInteger('status')->comment('产品状态，0下架，1上架');
            $table->tinyInteger('is_hot')->comment('是否热门，0非热门，1热门');
            $table->bigInteger('sort')->comment('排序');
            $table->string('share_title',255)->comment('分享标题');
            $table->string('share_content',255)->comment('分享描述');
            $table->text('goods_desc')->comment('产品描述');
            $table->string('goods_img',400)->comment('商品图片');
            $table->primary('goods_id');
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
        Schema::dropIfExists('goods');
    }
}
