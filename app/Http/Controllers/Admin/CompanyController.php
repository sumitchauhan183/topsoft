<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class CompanyController extends Controller
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
        $company = Company::get();
        return view('admin.company.list',[
            'title'=>'Company',
            'url' => 'company',
            'main'=> 'company',
            'company'=> $company,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function add(Request $request){

        return view('admin.company.add',[
            'title'=>'Add New Client',
            'url' => 'company/add',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function view($company_id){
        $company = Company::where('company_id',$company_id)->first();
        return view('admin.company.view',[
            'title'=>'Company Detail',
            'url' => 'company/view',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'company' => $company
        ]);
    }

    public function edit($company_id){
        $company = Company::where('company_id',$company_id)->first();
        return view('admin.company.edit',[
            'title'=>'Company Update',
            'url' => 'company/edit',
            'main'=> 'company',
            'admin'=> (object)$this->admin['data'],
            'company' => $company
        ]);
    }

    public function delete($company_id){
        try{
            $company = Company::where('company_id',$company_id)->get()->first();
           Company::where('company_id',$company_id)->delete();
        }
        catch(Exception $e){
            $company = Company::where('company_id',$company_id)->get()->first();
        }
        Utils::jsredirect("../../company");


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
