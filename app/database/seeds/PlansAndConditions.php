<?php

use Illuminate\Database\Seeder;

class PlansAndConditions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_condition_prices')->truncate();
        DB::table('plans')->truncate();
        DB::table('api_subscriptions')->truncate();
        $condition_data = [
            [
                'condition' => 'Requests',
                'condition_qty' => 10,
                'cicle' => 'Day',
                'charge_overlimit' => true,
                "price" => 0,
                "price_overlimit" => 0.01
            ],
            [
                'condition' => 'Requests',
                'condition_qty' => 1000,
                'cicle' => 'Month',
                'charge_overlimit' => true,
                "price" => 10,
                "price_overlimit" => 0.02,
            ],
            [
                'condition' => 'Requests',
                'cicle' => 'Unlimited',
                "price" => 49
            ]

        ];
        $plans = [
            [
                'name'=>'Free',
            ],
            [
                'name' => 'Basic',
            ],
            [
                'name' => 'Pro',
            ]
        ];
        foreach ($condition_data as $key => $condition) {
            $condition_id = DB::table('plan_condition_prices')->insertGetId($condition);
            $plans[$key]['plan_condition_price_id'] = $condition_id;
            DB::table('plans')->insert($plans[$key]);
        }
    }
}
