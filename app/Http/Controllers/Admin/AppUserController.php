<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Licences;
use App\Models\Company;
use App\Models\Devices;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class AppUserController extends Controller
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

    public function list($company_id){
        $licence = Licences::where('company_id',$company_id)->get()->first();
        $devices = Devices::where('company_id',$company_id)->get();
        return view('admin.devices.list',[
            'title'=>'App Users',
            'url' => 'devices',
            'main'=> 'company',
            'company_id'=> $company_id,
            'licence' => $licence,
            'devices' => $devices,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function add($company_id){
        
        return view('admin.devices.add',[
            'title'=>'Add App User',
            'url' => 'devices/add',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'company_id'=> $company_id
        ]);
    }

    public function view($device_id){
        $device = Devices::where('device_id',$device_id)->first();
        return view('admin.devices.view',[
            'title'=>'App User Detail',
            'url' => 'devices/view',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'devices' => $device
        ]);
    }

    public function edit($device_id){
        $device = Devices::where('device_id',$device_id)->first();
        return view('admin.devices.edit',[
            'title'=>'App User Update',
            'url' => 'devices/edit',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'devices' => $device
        ]);
    }

    public function delete($device_id){
        try{
            $device = Devices::where('device_id',$device_id)->get()->first();
            Devices::where('device_id',$device_id)->delete();
        }
        catch(Exception $e){
            $device = Devices::where('device_id',$device_id)->get()->first();
        }
        Utils::jsredirect("../../../../admin/company/$device->company_id/app-users");
        
        
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