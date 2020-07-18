<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAccessTokenAndAccessTokenSecretColumnSizeTo500OnTwitterAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('twitter_auths', function (Blueprint $table) {
            $table->string('access_token', 500)->change();
            $table->string('access_token_secret', 500)->change();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitter_auths', function (Blueprint $table) {
            $table->string('access_token', 255)->change();
            $table->string('access_token_secret', 255)->change();
        });
    }
}
