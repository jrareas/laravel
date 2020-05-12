<?php


namespace App\Services;


use App\Contracts\AddressValidation;
use App\Contracts\AddressValidationResponse;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;

class AddressValidationUSA  extends AddressValidation
{
    private function getLookUp() {
        $lookup = new Lookup();
        $lookup->setStreet($this->request->get('street_1'));
        $lookup->setStreet2($this->request->get('street_2'));
        $lookup->setUrbanization("");  // Only applies to Puerto Rico addresses
        $lookup->setCity($this->request->get('city'));
        $lookup->setState($this->request->get('province'));
        $lookup->setZipcode($this->request->get('postal_code'));
        return $lookup;
    }
    public function validateAddress() : AddressValidationResponse {
        $this->validation->make($this->request->all(), [
            'country' => 'required|size:3',
            'street_1' => 'required',
            //'postal_code' => 'regex:/^[0-9]{5}(-[0-9]{4})?$/',
            'province' => 'required',
            'city' => 'required'
        ])->validate();
        $staticCredentials = new StaticCredentials(config('app.smarty_streets_auth_id'), config("app.smarty_streets_auth_token"));

        $client = (new ClientBuilder($staticCredentials))
            ->buildUsStreetApiClient();


        try {
            $lookup = $this->getLookUp();
            $client->sendLookup($lookup);
            $results = $lookup->getResult();
            /*
            $lookup_serialized = serialize($lookup);
            $key = md5($lookup_serialized);
            $results = cache($key);
            if (!$results) {
                $client->sendLookup($lookup);
                cache([$key => $results]);
            }
            */
        }
        catch (SmartyException $ex) {
            $this->address_validation_response->status = false;
            $this->address_validation_response->errors = $ex->getMessage();
            return $this->address_validation_response;
        }
        catch (\Exception $ex) {
            $this->address_validation_response->status = false;
            $this->address_validation_response->errors = $ex->getMessage();
            return $this->address_validation_response;
        }


        foreach ($results as $row) {
            $address = app()->make('Address');
            $address->primary_number = $row->getComponents()->getPrimaryNumber();
            $address->street_1 = $row->getComponents()->getStreetName();
            $address->street_2 = $this->request->get('street_2');
            $address->street_number = $this->request->get('street_number');
            $address->city = $row->getComponents()->getCityName();
            $address->province = $row->getComponents()->getStateAbbreviation();
            $address->postal_code = $row->getComponents()->getZipcode();
            $address->country = $this->request->get('country');
            $address->postal_code_plus_4 = $row->getComponents()->getPlus4Code();
            $this->address_validation_response->addresses = $address;
        }
        $this->address_validation_response->status = true;
        return $this->address_validation_response;
    }
}