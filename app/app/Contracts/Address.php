<?php


namespace App\Contracts;


class Address
{
    protected $status;

    public $primary_number;
    public $street_1;
    public $street_2;
    public $street_number;
    public $city;
    public $province;
    public $country;
    public $postal_code;
    public $postal_code_plus_4;

    public function __set($field, $value) {
        if (property_exists($this, $field)) {
            $this->$field = $value;
        } else {
            throw new \Exception("Property $field does not exist on class " . get_class($this));
        }

    }

    public function jsonSerialize()
    {
        return [
            'street_1' => $this->street_1,
            'street_2' => $this->street_2,
            'street_number' => $this->street_number,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
        ];
    }
}