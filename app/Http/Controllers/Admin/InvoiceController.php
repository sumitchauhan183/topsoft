<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Invoices;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class InvoiceController extends Controller
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
        $invoices = Invoices::get();
        $companies = Company::get()->toArray();
        return view('admin.invoices.list',[
            'title'=>'Invoices',
            'url' => 'invoices',
            'main'=> 'invoices',
            'invoices'=> $invoices, 
            'company'=> $companies,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function view($invoice_id){
        $invoices = Invoices::where('invoice_id',$invoice_id)->first();
        return view('admin.invoices.view',[
            'title'=>'Invoice Detail',
            'url' => 'invoices/view',
            'main'=> 'invoices',
            'admin'=> (object)$this->admin['data'],
            'invoice' => $invoices
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