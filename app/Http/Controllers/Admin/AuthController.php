<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class AuthController extends Controller
{

    public function __construct(Request $request)
    {
        $session = Session()->get('user');
        dd($session);
    }

    public function login(){
        return view('admin.auth.login');
    }
}