<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Licences;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class LicenseController extends Controller
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

    public function add($company_id){
        
        return view('admin.licence.add',[
            'title'=>'Add Licence',
            'url' => 'license/add',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'company_id'=> $company_id
        ]);
    }

    public function view($licence_id){
        $license = Licences::where('licence_id',$licence_id)->first();
        return view('admin.licence.view',[
            'title'=>'License Detail',
            'url' => 'license/view',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'license' => $license
        ]);
    }

    public function edit($licence_id){
        $license = Licences::where('licence_id',$licence_id)->first();
        return view('admin.licence.edit',[
            'title'=>'License Update',
            'url' => 'license/edit',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'license' => $license
        ]);
    }

    public function delete($licence_id){
        try{
            $license = Licences::where('licence_id',$licence_id)->first();
            Licences::where('licence_id',$licence_id)->delete();
        }
        catch(Exception $e){
            $license = Licences::where('licence_id',$licence_id)->first();
        }
        Utils::jsredirect("../../../company");
        
        
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