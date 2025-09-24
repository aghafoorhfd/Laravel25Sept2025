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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address',255)->nullable();
            $table->string('address2',255)->nullable();
            $table->string('phone',30)->nullable();
            $table->date('birthday')->nullable();
            $table->string('city',255)->nullable();
            $table->string('state',255)->nullable();
            $table->string('country',255)->nullable();
            $table->integer('zip_code')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->bigInteger('avatar_id')->nullable();
            $table->text('bio')->nullable();
            $table->string('status',20)->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->integer('vendor_commission_amount')->nullable();
            $table->string('vendor_commission_type',30)->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('social_media')->nullable();


            $table->string('billing_first_name',255)->nullable();
            $table->string('billing_last_name',255)->nullable();
            $table->string('billing_address',255)->nullable();
            $table->string('billing_address2',255)->nullable();
            $table->string('billing_phone',30)->nullable();
            $table->string('billing_city',255)->nullable();
            $table->string('billing_state',255)->nullable();
            $table->string('billing_country',255)->nullable();
            $table->integer('billing_zip_code')->nullable();


            $table->softDeletes();
            $table->rememberToken();
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
