<?php


namespace App\Contracts;


use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;

abstract class AddressValidation
{
    protected $validation;
    protected $request;
    protected $address_validation_response;

    public function __construct(ValidationFactory $validation, Request $request, AddressValidationResponse $address_validation_response){
        $this->validation = $validation;
        $this->request = $request;
        $this->address_validation_response = $address_validation_response;
    }

    abstract public function validateAddress(): AddressValidationResponse;
}