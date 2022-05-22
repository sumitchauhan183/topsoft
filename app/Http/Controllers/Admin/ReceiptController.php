<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Receipts;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class ReceiptController extends Controller
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
        $receipts = Receipts::get();
        $companies = Company::get()->toArray();
        return view('admin.receipts.list',[
            'title'=>'Receipts',
            'url' => 'receipts',
            'main'=> 'receipts',
            'receipts'=> $receipts, 
            'company'=> $companies,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function view($receipt_id){
        $receipts = Receipts::where('receipt_id',$receipt_id)->first();
        return view('admin.receipts.view',[
            'title'=>'Receipt Detail',
            'url' => 'receipt/view',
            'main'=> 'receipts',
            'admin'=> (object)$this->admin['data'],
            'receipt' => $receipts
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