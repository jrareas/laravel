<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_uris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_uri')->unique();

            $table->timestamps();
        });
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('oauth_client_id');
            $table->bigInteger('request_uri_id');
            $table->decimal('size');
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
        //
        Schema::drop('request_uris');
        Schema::drop('requests');
    }
}
