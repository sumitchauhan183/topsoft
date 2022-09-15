<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return "Wrong page";
    }


    public function list(Request $request)
    {
        $input     = $request->all();
        try{
            $id = $input['id'];
            if($id=='all'):
                $events = Events::join('company as c','events.company_id','c.company_id')
                                    ->join('clients as cl','events.client_id','cl.client_id')
                                    ->select('events.*','c.name as company_name','cl.name as client_name')
                                    ->get()
                                    ->toArray();
            else:
                $events = Events::join('company as c','events.company_id','c.company_id')
                                    ->join('clients as cl','events.client_id','cl.client_id')
                                    ->select('events.*','c.name as company_name','cl.name as client_name')
                                    ->where('events.company_id',$id)
                                    ->get()
                                    ->toArray();
            endif;
            return json_encode([
                'error'=>false,
                'message'=>'event list',
                'events'=> $events
            ]);
        }
        catch(Excepyion $e){
            return json_encode([
                'error'=>true,
                'message'=>'Exception occured.',
                'exception'=> $e
            ]);
        }


    }
}
