<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Clients;
use App\Models\Items;
use App\Models\Invoices;
use App\Models\Receipts;
use App\Models\Events;
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
                'companies' => Company::get()->toArray(),
                'clients' => Clients::get()->toArray(),
                'items' => Items::get()->toArray(),
                'invoices' => Invoices::get()->toArray(),
                'receipts' => Receipts::get()->toArray(),
                'events' => Events::get()->toArray(),
                'admin'=> (object)$this->admin['data']
         ]);
    }

    public function profile(){

        return view('admin.profile',[
            'title'=> 'Admin Profile',
            'url'=> 'profile',
            'main'=> 'profile',
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
