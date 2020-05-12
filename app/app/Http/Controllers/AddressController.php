<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private $validation;
    private $fields = [
        'street_1',
        'street_2',
        'street_number',
        'country_id',
        'user_id',
        'postal_code',
        'province'
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ValidationFactory $validation)
    {
        $this->validation = $validation;
        $this->middleware('web');
        $this->middleware('auth');
    }

    /**
     * get all addresses for a user
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $address = Address::join('countries', 'addresses.country_id', '=', 'countries.id')->where('user_id', $request->get("user_id"))->get();
        return $address;
    }

    public function update($id, Request $request) {
        $this->validation->make($request->all(), [
            'street_1' => 'required|max:255',
            'postal_code' => 'required',
            'street_number' => 'required',
            'user_id' => 'required',
        ])->validate();

        $address = Address::find($id);
        return $this->save($request->all(),$address);
    }

    public function store(Request $request) {
        $this->validation->make($request->all(), [
            'street_1' => 'required|max:255',
            'postal_code' => 'required',
            'street_number' => 'required',
            'user_id' => 'required',
        ])->validate();

        return $this->save($request->all(),new Address);
    }

    public function save($data, $address) {
        foreach ($this->fields as $field) {
            $address->$field = $data[$field];
        }
        $address->save();
        return $address;

    }

}
