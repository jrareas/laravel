<?php

namespace App\Http\Controllers;

use App\Address;
use App\ApiMetadata;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class ApiRegistrationController extends Controller
{
    private $validation;
    private $fields = [
        'name',
        'description',
        'uri',
        'query_string',
        'method',
        'headers',
        'example_body',
        'example_response',
        'docs_uri',
        'image_id'
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ValidationFactory $validation)
    {
        $this->validation = $validation;
    }
    /**
     * get all addresses for a user
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        return view('apiregistrations');
    }

    public function get() {
        return ApiMetadata::get();
    }

    public function store(Request $request) {
        $this->localValidate($request);

        return $this->save($request->all(),new ApiMetadata);
    }
    private function localValidate($request) {
        $this->validation->make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'uri' => 'required',
            'method' => 'required',
            'headers' => 'required',
            'example_response' => 'required',
            'docs_uri' => 'required'
        ])->validate();
    }
    public function update($id, Request $request) {
        $this->localValidate($request);
        $apiMetadata = ApiMetadata::find($id);
        return $this->save($request->all(),$apiMetadata);

    }
    public function save($data, $apiData) {
        foreach ($this->fields as $field) {
            $apiData->$field = $data[$field];
        }
        $apiData->save();
        return $apiData;

    }

}
