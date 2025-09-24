<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrom10To11 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_languages', function (Blueprint $table) {

            if (!Schema::hasColumn('core_languages', 'last_build_at')) {
                $table->timestamp('last_build_at')->nullable();
            }
        });
        Schema::table('bravo_attrs', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_attrs', 'display_type')) {
                $table->string('display_type',255)->nullable();
            }
            if (!Schema::hasColumn('bravo_attrs', 'hide_in_single')) {
                $table->tinyInteger('hide_in_single')->nullable();
            }
        });
        Schema::table('bravo_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_bookings', 'number')) {
                $table->smallInteger('number')->nullable();
            }
        });
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verify_submit_status')) {
                $table->string('verify_submit_status',30)->nullable();
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->smallInteger('is_verified')->nullable();
            }
        });
        Schema::create('bravo_payouts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('vendor_id')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('status',50)->nullable();
            $table->string("payout_method",50)->nullable();
            $table->text("account_info")->nullable();

            $table->text("note_to_admin")->nullable();
            $table->text("note_to_vendor")->nullable();
            $table->integer('last_process_by')->nullable();
            $table->timestamp("pay_date")->nullable();// admin pay date

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });


        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name',255)->nullable();
            }
        });
        
        Schema::table('bravo_terms', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_terms', 'icon')) {
                $table->string('icon',50)->nullable();
            }
        });
        Schema::table('bravo_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_bookings', 'object_child_id')) {
                $table->bigInteger('object_child_id')->nullable();
            }
        });
        if (!Schema::hasTable('user_wishlist')) {
            Schema::create('user_wishlist', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('object_id')->nullable();
                $table->string('object_model', 255)->nullable();
                $table->integer('user_id')->nullable();
                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('bravo_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_bookings', 'buyer_fees')) {
                $table->text('buyer_fees')->nullable();
                $table->decimal('total_before_fees',10,2)->nullable();
            }
            if (!Schema::hasColumn('bravo_bookings', 'paid_vendor')) {
                $table->tinyInteger('paid_vendor')->nullable();
            }
        });
        Schema::table('bravo_review', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_review', 'vendor_id')) {
                $table->bigInteger('vendor_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bravo_payouts');
        Schema::dropIfExists('user_wishlist');

    }
}
