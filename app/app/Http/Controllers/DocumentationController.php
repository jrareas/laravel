<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function index(Request $request) {
        return view('documentation.docs');
    }

    public function get(Request $request) {
        return view("documentation.doc",['uri' => htmlspecialchars($request->get('uri'))]);
    }
}
