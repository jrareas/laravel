<?php


namespace App\Services;

use App\Contracts\AddressValidation;
use App\Contracts\AddressValidationResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;


class AddressValidationCanada extends AddressValidation
{
    private function getUrl() {
        $query_string = [
            "Key=" . config('app.canada_post_key'),
            "SearchTerm=". sprintf("%s %s %s, %s %s",$this->request->get('street_number'), $this->request->get('street_1'), $this->request->get('street_2'), $this->request->get('province'), $this->request->get('postal_code')),
            "Country=" . $this->request->get('country')
        ];

        return config('app.canada_post_address_complete_url') . implode("&",$query_string);
    }

    public function validateAddress() : AddressValidationResponse {
        $this->validation->make($this->request->all(), [
            'country' => 'required|size:3',
            'street_1' => 'required',
            'postal_code' => 'required|regex:/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/',
            'street_number' => 'required'
        ])->validate();
        $addresses = simplexml_load_file($this->getUrl());

        $ret = app()->make('AddressValidationResponse');
        if ($addresses->Columns->Column->attributes()->Name == "Error")
        {
            $ret->status = false;
            $ret->errors = "[ID] " . $addresses->Rows->Row->attributes()->Error . " [DESCRIPTION] " . $addresses->Rows->Row->attributes()->Description . " [CAUSE] " . $addresses->Rows->Row->attributes()->Cause . " [RESOLUTION] " . $addresses->Rows->Row->attributes()->Resolution;
            return $ret;
        }


        foreach ($addresses->Rows->Row as $row) {
            $address = app()->make('Address');

            list($city,$province, $postal_code) = explode(',',$row->attributes()->Description);
            $address->street_1 = $row->attributes()->Text;
            $address->street_2 = $this->request->get('street_2');
            $address->street_number = $this->request->get('street_number');
            $address->city = $city;
            $address->province = $province;
            $address->postal_code = $postal_code;
            $address->country = $this->request->get('country');
            $ret->addresses = $address;
        }
        $ret->status = true;
        return $ret;
    }
}