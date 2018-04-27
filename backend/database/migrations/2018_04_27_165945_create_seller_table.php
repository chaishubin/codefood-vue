<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller', function (Blueprint $table) {
            $table->bigInteger('id')->comment('商家id');
            $table->string('session_key','100')->comment('验证登陆状态的唯一标识');
            $table->string('user_mobile','24')->comment('商家电话');
            $table->string('username','100')->comment('商家姓名');
            $table->string('password','100')->comment('密码');
            $table->string('address','400')->comment('店铺地址');
            $table->string('shop_name','100')->comment('店铺名称');
            $table->string('shop_logo','400')->comment('店铺头像');
            $table->tinyInteger('status')->comment('商家状态,1启用，0禁用');
            $table->timestamps();
            $table->primary('id');
        });
        //获取表前缀
        $prefix = config('database')['connections']['mysql']['prefix'];
        DB::statement("ALTER TABLE `{$prefix}seller` comment'商家信息'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller');
    }
}
