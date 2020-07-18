<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followed_users', function (Blueprint $table) {
            $table->string('email', 255);
            $table->string('twitter_user_name');
            $table->boolean('is_follow_flag')->default(0);
            $table->timestamps();

            $table->primary(['email', 'twitter_user_name']);
            $table->index(['email', 'twitter_user_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followed_users');
    }
}
