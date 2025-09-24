<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            //Course info
            $table->string('title', 255)->nullable();
            $table->string('slug',255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('banner_image_id')->nullable();
            $table->integer('pdf_file_id')->nullable();
            $table->text('short_desc')->nullable();
            $table->integer('category_id')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('gallery', 255)->nullable();
            $table->string('video', 255)->nullable();
            //Price
            $table->decimal('price', 12,2)->nullable();
            $table->decimal('sale_price', 12,2)->nullable();
            $table->decimal('easypaisa_price', 12,2)->nullable();

            //Course type
            $table->integer('duration')->nullable();

            //Extra Info
            $table->text('faqs')->nullable();
            $table->string('status',50)->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();

            //Languages
            $table->bigInteger('views')->nullable();
            $table->timestamps();

            $table->tinyInteger('default_state')->default(1)->nullable();
        });

        Schema::create('bravo_course_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255)->nullable();
            $table->integer('image_id')->nullable();
            $table->text('content')->nullable();
            $table->string('slug',255)->nullable();
            $table->string('status',50)->nullable();
            $table->nestedSet();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();

            //Languages
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang',10)->nullable();

            $table->timestamps();
        });

        Schema::create('bravo_course_translations', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            //Tour info
            $table->string('title', 255)->nullable();
            $table->string('slug',255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->text('short_desc')->nullable();
            $table->string('address', 255)->nullable();
            $table->text('faqs')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });


        Schema::create('bravo_course_category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });

        Schema::create('bravo_course_term', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('term_id')->nullable();
            $table->integer('course_id')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();

        });

        Schema::create('bravo_course_section', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('course_id')->nullable();

            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('service',50)->nullable();

            $table->string('display_type',255)->nullable();
            $table->tinyInteger('hide_in_single')->nullable();
            $table->tinyInteger('active')->default(1)->nullable();
            $table->tinyInteger('display_order')->default(0)->nullable();


            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('bravo_course_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('section_id')->nullable();
            $table->integer('course_id')->nullable();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();
            $table->text('short_desc')->nullable();
            $table->integer('duration')->nullable();
            $table->string('slug',255)->nullable();
            $table->bigInteger('file_id')->nullable();
            $table->string('type',30)->nullable();
            $table->text('url')->nullable();
            $table->string('preview_url')->nullable();


            $table->tinyInteger('active')->default(1)->nullable();
            $table->tinyInteger('display_order')->default(0)->nullable();


            //Languages
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang',10)->nullable();


            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('image_id')->nullable();
            $table->string('icon',50)->nullable();

            $table->index(['course_id','section_id']);

        });

        Schema::create('bravo_course_section_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });

        Schema::create('bravo_course_lessons_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });


        Schema::create('bravo_course_meta', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('course_id')->nullable();

            $table->tinyInteger('enable_person_types')->nullable();
            $table->text('person_types')->nullable();

            $table->tinyInteger('enable_extra_price')->nullable();
            $table->text('extra_price')->nullable();

            $table->text('discount_by_people')->nullable();

            $table->tinyInteger('enable_open_hours')->nullable();
            $table->text('open_hours')->nullable();


            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('core_course_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_id')->nullable();
            $table->integer('tag_id')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::table('bravo_courses', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_courses', 'review_score')) {
                $table->decimal('review_score',2,1)->nullable();
            }
        });

        Schema::table('bravo_courses', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_courses', 'include')) {
                $table->text('include')->nullable();
            }
            if (!Schema::hasColumn('bravo_courses', 'exclude')) {
                $table->text('exclude')->nullable();
            }
            if (!Schema::hasColumn('bravo_courses', 'itinerary')) {
                $table->text('itinerary')->nullable();
            }
        });
        Schema::table('bravo_course_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_course_translations', 'include')) {
                $table->text('include')->nullable();
            }
            if (!Schema::hasColumn('bravo_course_translations', 'exclude')) {
                $table->text('exclude')->nullable();
            }
            if (!Schema::hasColumn('bravo_course_translations', 'itinerary')) {
                $table->text('itinerary')->nullable();
            }
        });

        Schema::create('bravo_course_lesson_completion', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('lesson_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('state')->nullable();
            $table->tinyInteger('percent')->nullable();

            $table->index(['course_id','lesson_id','user_id']);
            $table->index(['course_id','user_id']);

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();

        });
        Schema::create('bravo_course_user', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->bigInteger('order_id')->nullable();

            $table->softDeletes();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();

            $table->unique(['course_id','user_id']);
            $table->timestamps();

        });

        Schema::create('bravo_course_user_completion', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('state')->nullable();
            $table->tinyInteger('percent')->nullable();

            $table->index(['course_id','user_id']);

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();

        });

        Schema::create('bravo_course_study_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('lesson_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->tinyInteger('state')->nullable();
            $table->tinyInteger('percent')->nullable();
            $table->index(['course_id','lesson_id','user_id']);
            $table->index(['course_id','user_id']);
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
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
        Schema::dropIfExists('bravo_courses');
        Schema::dropIfExists('bravo_course_category');
        Schema::dropIfExists('bravo_course_translations');
        Schema::dropIfExists('bravo_course_category_translations');
        Schema::dropIfExists('bravo_course_term');
        Schema::dropIfExists('bravo_course_dates');
        Schema::dropIfExists('bravo_course_section');
        Schema::dropIfExists('bravo_course_lessons');
        Schema::dropIfExists('bravo_course_section_translations');
        Schema::dropIfExists('bravo_course_lessons_translations');
        Schema::dropIfExists('bravo_course_meta');
        Schema::dropIfExists('bravo_course_study_log');
        Schema::dropIfExists('bravo_course_user');
        Schema::dropIfExists('bravo_course_user_completion');
        Schema::dropIfExists('bravo_course_lesson_completion');
        Schema::dropIfExists('bravo_course_lesson_completion');
        Schema::dropIfExists('core_course_tag');
    }
}
