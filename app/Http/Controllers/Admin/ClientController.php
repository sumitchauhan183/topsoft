<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Clients;
use App\Models\Company;
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
        $clients = Clients::join('company as c','clients.company_id','c.company_id')->select('clients.*','c.name as company_name')->get();
        $companies = Company::get()->toArray();
        return view('admin.clients.list',[
            'title'=>'Clients',
            'url' => 'clients',
            'main'=> 'clients',
            'clients'=> $clients,
            'company'=> $companies,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function add(Request $request){
        $companies = Company::get();
        return view('admin.clients.add',[
            'title'=>'Add New Client',
            'url' => 'clients/add',
            'main'=> 'clients',
            'companies'=> $companies,
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

    public function delete($client_id){
        try{
            $clients = Clients::where('client_id',$client_id)->first();
            //Clients::where('client_id',$client_id)->delete();
        }
        catch(Exception $e){
            $clients = Clients::where('client_id',$client_id)->first();
        }
        Utils::jsredirect("../../clients");
        
        
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