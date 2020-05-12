<?php


namespace App\Contracts;


class AddressValidationResponse implements \JsonSerializable
{
    protected $addresses = [];
    protected $status;
    protected $errors = [];

    public function __set($field, $value) {
        if (property_exists($this, $field)) {
            if (is_array($this->$field)) {
                $this->$field[] = $value;
            } else {
                $this->$field = $value;
            }

        } else {
            throw \Exception("Property $field does not exist on class " . get_class($this));
        }

    }
    public function jsonSerialize()
    {
        $data = [
                'addresses' => $this->addresses,
                'status' => $this->status
            ];
        if ($this->status === false) {
            $data['errors'] = $this->errors;
        }
        return $data;
    }

}