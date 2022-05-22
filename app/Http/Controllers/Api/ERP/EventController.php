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


    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id','event_type','status','event_date'
        ]);
        if(!$required):
                $input = $this->SetColumnsToBlank($input,[
                    'observation','is_completed', 'signature', 'completed_date'
                ]);	
                if($input['completed_date']!=""):
                        $data = [
                            'client_id'=>$input['client_id'],
                            'event_type' => $input['event_type'],
                            'status' => $input['status'],
                            'observation' => $input['observation'],
                            'is_completed' => $input['is_completed'],
                            'signature' => $input['signature'],
                            'completed_date' => $input['completed_date'],
                            'event_date'   => $input['event_date']
                        ];
                    else:
                        $data = [
                            'client_id'=>$input['client_id'],
                            'event_type' => $input['event_type'],
                            'status' => $input['status'],
                            'observation' => $input['observation'],
                            'is_completed' => $input['is_completed'],
                            'signature' => $input['signature'],
                            'event_date'   => $input['event_date']
                        ];
                endif;

                $events = Events::create($data);
                if($events):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Event created successfully",
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue client not created",
                        'code'=>201
                    ]);
                endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
        
    }

    public function update(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id','event_type','status','event_id','event_date'
        ]);
        if(!$required):
            
                $input = $this->SetColumnsToBlank($input,[
                    'observation','is_completed', 'signature', 'completed_date'
                ]);	
                $event = Events::where('event_id',$input['event_id'])->update([
                        'client_id'=>$input['client_id'],
                        'event_type' => $input['event_type'],
                        'status' => $input['status'],
                        'observation' => $input['observation'],
                        'is_completed' => $input['is_completed'],
                        'signature' => $input['signature'],
                        'completed_date' => $input['completed_date'],
                        'event_date' => $input['event_date']
                ]);
                if($event):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Details updated successfully",
                        'code'=>201
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue Event not created",
                        'code'=>201
                    ]);
                endif;
                
                
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
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

    public function delete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'event_id'
        ]);
        if(!$required):
            $event = Events::where('event_id',$input['event_id'])->delete();
            if($event):
                return json_encode([
                    'error'=>false,
                    'message'=>"event removed successfully",
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"sever issue client not removed",
                    'code'=>201
                ]);
            endif;
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
