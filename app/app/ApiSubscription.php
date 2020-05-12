<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiSubscription extends Model
{
    public $timestamps = false;
    /**
     * Get the user's history.
     */
    public function api()
    {
        return $this->hasOne('App\ApiMetadata','id','api_id');
    }
    /**
     * Get the user's history.
     */
    public function plan()
    {
        return $this->hasOne('App\Plan', 'id','plan_id');
    }
}
