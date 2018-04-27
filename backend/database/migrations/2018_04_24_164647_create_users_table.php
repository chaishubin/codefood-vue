<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id')->comment('用户id');
            $table->string('name','100')->comment('用户姓名');
            $table->string('tel','100')->comment('电话');
            $table->string('email','255')->comment('邮箱');
            $table->string('password','255')->comment('密码');
            $table->string('icon','400')->comment('头像');
            $table->string('open_id','255')->comment('微信open_id');
            $table->tinyInteger('status')->comment('状态');
            $table->integer('last_login_ip')->comment('登陆ip');
            $table->string('session_key','255')->comment('session_key');
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
        Schema::dropIfExists('users');
    }
}
