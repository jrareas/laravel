<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidEmailController extends Controller
{
    public function validate($email) {
        list($userName, $mailDomain) = explode("@", $email);
        //$data
    }

    private function validateDomain($domain) {

        return checkdnsrr($domain);
    }
}
