<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Events;
use App\Models\Clients;
use Exception;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    private $input; 
    public function __construct(Request $request)
    {
       
        $this->input = $request->all();
        $required = $this->checkRequiredParams($this->input,['token']);
        
        if($required):
            echo json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
            die();
        endif;
        if(!$this->checkToken()):
            echo json_encode([
                'error'=>true,
                'message'=>"Invalid Token",
                'code'=>201
            ]);
            die();
        endif;
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

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'page','count'
        ]);
        if(!$required):
            if(isset($input['month'])):
                $timestamp    = strtotime(''.$input['month'].' '.$input['year'].'');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->skip($input['page']*$input['count'])
                                    ->take($input['count'])
                                    ->get();
            endif;
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $events,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }


    public function listbyclient(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'page','count','client_id'
        ]);
        if(!$required):
            if(isset($input['month'])):
                $timestamp    = strtotime(''.$input['month'].' '.$input['year'].'');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->where('events.client_id',$input['client_id'])
                                ->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.client_id',$input['client_id'])
                                    ->skip($input['page']*$input['count'])
                                    ->take($input['count'])
                                    ->get();
            endif;
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $events,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }

    public function listbytype(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'page','count','event_type'
        ]);
        if(!$required):
            if(isset($input['month'])):
                $timestamp    = strtotime(''.$input['month'].' '.$input['year'].'');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->where('events.event_type',$input['event_type'])
                                ->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.event_type',$input['event_type'])
                                    ->skip($input['page']*$input['count'])
                                    ->take($input['count'])
                                    ->get();
            endif;
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $events,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }

    public function listbystatus(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'page','count','status'
        ]);
        if(!$required):
            if(isset($input['month'])):
                $timestamp    = strtotime(''.$input['month'].' '.$input['year'].'');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->where('events.status',$input['status'])
                                ->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.status',$input['status'])
                                    ->skip($input['page']*$input['count'])
                                    ->take($input['count'])
                                    ->get();
            endif;
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $events,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }



    private function checkToken(){
        $token = $this->input['token'];
        if(env('erp_token'!=$token)):
            return false;
        else:
            return true;
        endif;                    
     
}

   private function checkRequiredParams($input,$required){
        foreach($required as $r):
            if(isset($input["$r"])==false || $r=''):
                return $r;
            endif;
        endforeach;
        return false;
   }

    private function generateToken($id)
    {
        return  md5($id.time());
    }

    private function SetColumnsToBlank($input,$required){
     foreach($required as $r):
         if(isset($input["$r"])==false):
             $input["$r"] = '';
         endif;
     endforeach;
     return $input;
 }
    
}
