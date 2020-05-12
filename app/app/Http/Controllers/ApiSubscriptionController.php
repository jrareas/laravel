<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use App\ApiSubscription;

class ApiSubscriptionController extends Controller
{
    public function __construct(ValidationFactory $validation)
    {
        $this->validation = $validation;
        $this->middleware('web');
        $this->middleware('auth');
    }

    public function get(Request $request, $user_id) {
        $subs = ApiSubscription::all();

        // eager load the api
        foreach ($subs as $sub) {
            $api = $sub->api;
            $plan = $sub->plan;
        }

        return $subs;
    }

    public function cancel(Request $request, $id) {
        $subs = ApiSubscription::find($id);
        $subs->date_cancelation = now();
        return $subs->save();
    }

    public function update(Request $request,$id) {
        $this->validateRequest($request);
        $this->cancel($request,$id);

        return $this->save($request, new ApiSubscription);
    }

    private function validateRequest(Request $request) {
        return $this->validation->make($request->all(), [
            'api_id' => 'required',
            'plan_id' => 'required',
            'client_id' => 'required',
        ])->validate();
    }
    private function save(Request $request, ApiSubscription $subscription) {
        $subscription->api_id = $request->get('api_id');
        $subscription->plan_id = $request->get('plan_id');
        $subscription->client_id = $request->get('client_id');
        $subscription->date_subscribed = now();
        return $subscription->save();
    }

    public function store(Request $request) {
        $this->validateRequest($request);
        return $this->save($request, new ApiSubscription);
    }
}
