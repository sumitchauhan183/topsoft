<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Events;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class EventController extends Controller
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
        $events = Events::get();
        $companies = Company::get()->toArray();
        return view('admin.events.list',[
            'title'=>'Events',
            'url' => 'events',
            'main'=> 'events',
            'events'=> $events,
            'company'=> $companies,
            'admin'=> (object)$this->admin['data']
        ]);
    }

    public function view($event_id){
        $events = Invoices::where('invoice_id',$event_id)->first();
        return view('admin.events.view',[
            'title'=>'Event Detail',
            'url' => 'events/view',
            'main'=> 'events',
            'admin'=> (object)$this->admin['data'],
            'event' => $events
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
