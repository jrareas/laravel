<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function condition() {
        return $this->hasOne('App\PlanConditionPrice','id','plan_condition_price_id');
    }
}
