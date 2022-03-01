<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class DashboardController extends Controller
{

    private $admin;
    public function __construct(Request $request)
    { 
        $this->admin = Session()->get('admin');
        if(!$this->admin):
            Utils::jsredirect(route('admin.login'));
        else:
            $this->checkToken();    
        endif;

    }

    public function dashboard(){
        
        return view('admin.dashboard',[
                'title'=> 'Admin Dashboard',
                'url'=> 'dashboard',
                'main'=> 'dashboard',
                'admin'=> (object)$this->admin['data']
         ]);
    }

    private function checkToken(){
        $check = Admin::where('login_token',$this->admin['token'])
                ->where('admin_id',$this->admin['data']['admin_id'])->get()->count();
        if(!$check):
            session()->flush();
            Utils::jsredirect(route('admin.login'));
        else:  
            $admin = Admin::where('admin_id',$this->admin['data']['admin_id'])
                ->get()->first()->toArray();
                Session()->put('admin',[
                   "type"=>'admin',
                   "data"=>$admin,
                   "token" => $admin['login_token']
            ]);
        $this->admin = Session()->get('admin');      
        endif;
        
    }


}