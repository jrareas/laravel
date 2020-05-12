<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class PlansController extends Controller
{
    public function get(Request $request) {
        $plans = Plan::get();
        foreach ($plans as $plan) {
            $condition = $plan->condition;
        }
        return $plans;
    }
}
