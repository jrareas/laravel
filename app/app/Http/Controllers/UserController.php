<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    public function get(Request $request) {
        $users = User::get();
        foreach ($users as $user) {
            $user->isAdmin = $user->hasRole('admin');
        }
        return $users;
    }

    public function markadmin($user_id, $flag = true) {
        $user = User::find($user_id);
        $admin_role = config('roles.models.role')::where('name', '=', 'admin')->first();

        if($flag == "true") {
            $user->attachRole($admin_role);
        } else {
            $user->detachRole($admin_role);
        }

        $user->isAdmin = $user->hasRole('admin');

        return $user;
    }

}
