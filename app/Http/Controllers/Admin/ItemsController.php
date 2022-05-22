<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Clients;
use App\Models\Company;
use App\Models\Items;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class ItemsController extends Controller
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
        $items = Items::get();
        $companies = Company::get()->toArray();
        return view('admin.items.list',[
            'title'=>'Items',
            'url' => 'items',
            'main'=> 'items',
            'items'=> $items, 
            'company'=> $companies,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function add(Request $request){
        $companies = Company::get();
        return view('admin.items.add',[
            'title'=>'Add New Item',
            'url' => 'items/add',
            'main'=> 'items',
            'companies'=> $companies,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function view($item_id){
        $items = Items::where('item_id',$item_id)->first();
        $companies = Company::get();
        return view('admin.items.view',[
            'title'=>'Item Detail',
            'url' => 'items/view',
            'main'=> 'items',
            'companies'=> $companies,
            'admin'=> (object)$this->admin['data'],
            'item' => $items
        ]);
    }

    public function edit($item_id){
        $items = Items::where('item_id',$item_id)->first();
        $companies = Company::get();
        return view('admin.items.edit',[
            'title'=>'Item Update',
            'url' => 'items/edit',
            'main'=> 'items',
            'companies'=> $companies,
            'admin'=> (object)$this->admin['data'],
            'item' => $items
        ]);
    }

    public function delete($item_id){
      
            Items::where('item_id',$item_id)->delete();
        
        Utils::jsredirect("../../items");
        
        
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