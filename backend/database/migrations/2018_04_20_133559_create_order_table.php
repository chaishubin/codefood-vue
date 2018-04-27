<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigInteger('id')->comment('订单id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('goods_id')->comment('商品id');
            $table->decimal('order_money',20,2)->comment('订单金额');
            $table->decimal('coupon',20,2)->comment('优惠券');
            $table->decimal('pay_money',20,2)->comment('实付金额');
            $table->tinyInteger('pay_way')->comment('支付方式');
            $table->integer('order_time')->comment('下单时间');
            $table->integer('pay_time')->comment('付款时间');
            $table->tinyInteger('order_status')->comment('订单状态');
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
        Schema::dropIfExists('order');
    }
}
