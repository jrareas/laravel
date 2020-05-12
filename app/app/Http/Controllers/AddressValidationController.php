<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;

class AddressValidationController extends Controller
{
    protected $address_validation;

    protected $validation;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ValidationFactory $validation)
    {
        $this->validation = $validation;
    }

    private function setAddressValidationObject(Request $request) {
        switch ($request->get('country')){
            case 'CAN':
                $this->address_validation =  app()->make('AddressValidationCanada');
                break;
            case 'USA':
                $this->address_validation =  app()->make('AddressValidationUSA');
                break;
            default:
                return response(['message'=>"Country {$request->get('country')} not supported."],404);
        }
    }
    public function validateAddress(Request $request) {
        $this->setAddressValidationObject($request);
        return response()->json($this->address_validation->validateAddress($request));

    }
}
