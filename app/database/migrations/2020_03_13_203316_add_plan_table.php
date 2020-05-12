<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("plan_condition_prices", function(Blueprint $table){
            $table->id();
            $table->string('condition');
            $table->float('price');
            $table->float('price_overlimit')->nullable();
            $table->string('cicle');
            $table->float('condition_qty')->nullable();
            $table->boolean('charge_overlimit')->default(false);
        });
        Schema::create("plans", function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('plan_condition_price_id');
            $table->timestamps();
        });
        Schema::create('api_subscriptions', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->bigInteger('plan_id');
            $table->bigInteger('api_id');
            $table->dateTime('date_subscribed');
            $table->dateTime('date_cancelation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("api_subscriptions");
        Schema::dropIfExists("plans");
        Schema::dropIfExists('plan_condition_prices');
    }
}
