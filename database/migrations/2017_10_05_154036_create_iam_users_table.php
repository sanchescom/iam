<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('iam_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique()->index();
            $table->string('name');
            $table->string('email');
            $table->string('username')->unique();
            $table->string('password');
            $table->dateTime('logged_at')->nullable();
            $table->boolean('active')->defeault(true);
            $table->timestamps();
        });

        Schema::create('iam_users_has_access_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iam_users_id')->unsigned();
            $table->string('uuid')->unique()->index();
            $table->string('key');
            $table->json('hosts')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('iam_users_id')->references('id')->on('iam_users');
        });

        Schema::create('iam_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique()->index();
            $table->string('name');
            $table->boolean('active')->defeault(true);
            $table->timestamps();
        });

        Schema::create('iam_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique()->index();
            $table->string('name');
            $table->boolean('active')->defeault(true);
            $table->timestamps();
        });

        Schema::create('iam_access_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique()->index();
            $table->integer('iam_service_id')->unsigned();
            $table->string('name');
            $table->boolean('active')->defeault(true);
            $table->timestamps();

            $table->foreign('iam_service_id')->references('id')->on('iam_services');
        });

        Schema::create('iam_users_has_access_levels', function (Blueprint $table) {

            $table->integer('iam_users_id')->unsigned();
            $table->integer('iam_access_levels_id')->unsigned();

            $table->foreign('iam_users_id')->references('id')->on('iam_users');
            $table->foreign('iam_access_levels_id')->references('id')->on('iam_access_levels');
        });

        Schema::create('iam_groups_has_access_levels', function (Blueprint $table) {
            $table->integer('iam_groups_id')->unsigned();
            $table->integer('iam_access_levels_id')->unsigned();

            $table->foreign('iam_groups_id')->references('id')->on('iam_groups');
            $table->foreign('iam_access_levels_id')->references('id')->on('iam_access_levels');
        });


        Schema::create('iam_users_has_groups', function (Blueprint $table) {
            $table->integer('iam_users_id')->unsigned();
            $table->integer('iam_groups_id')->unsigned();

            $table->foreign('iam_groups_id')->references('id')->on('iam_groups');
            $table->foreign('iam_users_id')->references('id')->on('iam_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('iam_users_has_groups');
        Schema::dropIfExists('iam_groups_has_access_levels');
        Schema::dropIfExists('iam_users_has_access_levels');
        Schema::dropIfExists('iam_users_has_access_keys');
        Schema::dropIfExists('iam_users');
        Schema::dropIfExists('iam_groups');
        Schema::dropIfExists('iam_services');
        Schema::dropIfExists('iam_access_levels');
        Schema::enableForeignKeyConstraints();
    }
}
