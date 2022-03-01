<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Clients;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class ClientController extends Controller
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

    public function list(Request $request){
        $clients = Clients::get();
        return view('admin.clients.list',[
            'title'=>'Clients',
            'url' => 'clients',
            'main'=> 'clients',
            'clients'=> $clients,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function add(Request $request){
        
        return view('admin.clients.add',[
            'title'=>'Add New Client',
            'url' => 'clients/add',
            'main'=> 'clients',
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function view($client_id){
        $clients = Clients::where('client_id',$client_id)->first();
        return view('admin.clients.view',[
            'title'=>'Client Detail',
            'url' => 'clients/view',
            'main'=> 'clients',
            'admin'=> (object)$this->admin['data'],
            'client' => $clients
        ]);
    }

    public function edit($client_id){
        $clients = Clients::where('client_id',$client_id)->first();
        return view('admin.clients.edit',[
            'title'=>'Client Update',
            'url' => 'clients/edit',
            'main'=> 'clients',
            'admin'=> (object)$this->admin['data'],
            'client' => $clients
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