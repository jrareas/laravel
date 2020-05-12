<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileInfoController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $data = $user->getAttributes();
        return view('profile_info', ["data" =>json_encode($data)]);
    }
}