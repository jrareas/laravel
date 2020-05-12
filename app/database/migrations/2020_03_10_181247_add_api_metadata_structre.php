<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiMetadataStructre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("api_metadata", function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('uri');
            $table->string("query_string")->nullable();;
            $table->string("method");
            $table->text("headers")->nullable();
            $table->text("example_body")->nullable();
            $table->text("example_response");
            $table->string("docs_uri")->nullable();
            $table->boolean('enabled')->default(1);
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
        Schema::dropIfExists('api_metadata');
    }
}
