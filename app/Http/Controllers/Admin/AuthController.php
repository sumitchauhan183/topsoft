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
        
    }

    public function login(){
        $session = Session()->get('admin');
        if($session):
            Utils::jsredirect(route('admin.dashboard'));
        else:
            return view('admin.auth.login',[
                'title'=> 'Administrator Login',
                'url'=>'login'
            ]);
        endif;
        
    }

    
    public function logout()
    {
        session()->flush();
        return Utils::jsredirect(route('admin.login'));
    }
}