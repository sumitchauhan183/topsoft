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
    private $company_id;
    public function __construct(Request $request)
    {

        $this->input = $request->all();
        $required = $this->checkRequiredParams($this->input,['device_id','token']);

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
        else:
            $device = $this->deviceDetail();
            $this->company_id = $device->company_id;
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
            'client_id','event_type','event_date'
        ]);
        if(!$required):
                $input = $this->SetColumnsToBlank($input,[
                    'observation','is_completed', 'status','signature', 'completed_date','latitude','longitude'
                ]);
                if($input["event_type"]=="checklist"):
                    $data = [
                        'client_id'=>$input['client_id'],
                        'company_id'=>$this->company_id,
                        'device_id'=>$input['device_id'],
                        'event_type' => $input['event_type'],
                        'observation' => $input['observation'],
                        'checklist' => json_encode($input['checklist']),
                        'event_date'   => $input['event_date'],
                        'latitude' => $input['latitude'],
                        'longitude'   => $input['longitude']
                    ];
                else:
                        $data = [
                            'client_id'=>$input['client_id'],
                            'company_id'=>$this->company_id,
                            'device_id'=>$input['device_id'],
                            'event_type' => $input['event_type'],
                            'status' => $input['status'],
                            'observation' => $input['observation'],
                            'is_completed' => $input['is_completed'],
                            'signature' => $input['signature'],
                            'event_date'   => $input['event_date'],
                            'latitude' => $input['latitude'],
                            'longitude'   => $input['longitude']
                        ];
                endif;
            if($input['completed_date']!=""):
                $data['completed_date'] = $input['completed_date'];
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
            'client_id','event_type','event_id','event_date','device_id'
        ]);
        if(!$required):

                $input = $this->SetColumnsToBlank($input,[
                    'observation','is_completed','status', 'signature', 'completed_date','latitude','longitude'
                ]);
                if($input["event_type"]=="checklist"):
                    $data = [
                        'client_id'=>$input['client_id'],
                        'device_id'=>$input['device_id'],
                        'event_type' => $input['event_type'],
                        'observation' => $input['observation'],
                        'checklist' => json_encode($input['checklist']),
                        'event_date'   => $input['event_date'],
                        'latitude' => $input['latitude'],
                        'longitude'   => $input['longitude']
                    ];
                else:
                    $data = [
                        'client_id'=>$input['client_id'],
                        'device_id'=>$input['device_id'],
                        'event_type' => $input['event_type'],
                        'status' => $input['status'],
                        'observation' => $input['observation'],
                        'is_completed' => $input['is_completed'],
                        'signature' => $input['signature'],
                        'event_date' => $input['event_date'],
                        'latitude' => $input['latitude'],
                        'longitude'   => $input['longitude']
                    ];
                endif;
            if($input['completed_date']!=""):
                $data['completed_date'] = $input['completed_date'];
            endif;
                $event = Events::where('event_id',$input['event_id'])->update($data);
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
                //$timestamp    = strtotime(''.$input['month'].' '.$input['year'].'');
                $timestamp = strtotime($input["year"].'-'.$input['month'].'-01');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.device_id',$input['device_id'])
                                ->where('events.company_id',$this->company_id)
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last);
                                if(isset($input['client_id'])):
                                    if($input['client_id']!=""):
                                        $events = $events->where('events.client_id',$input['client_id']);
                                    endif;
                                endif;

                $events = $events->skip($input['page']*$input['count'])
                    ->take($input['count'])
                    ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.device_id',$input['device_id'])
                                    ->where('events.company_id',$this->company_id);
                                    if(isset($input['client_id'])):
                                        if($input['client_id']!=""):
                                            $events = $events->where('events.client_id',$input['client_id']);
                                        endif;
                                    endif;

                $events = $events->skip($input['page']*$input['count'])
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
                $timestamp = strtotime($input["year"].'-'.$input['month'].'-01');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->where('events.device_id',$input['device_id'])
                                ->where('events.company_id',$this->company_id)
                                ->where('events.client_id',$input['client_id'])
                                ->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.device_id',$input['device_id'])
                                    ->where('events.company_id',$this->company_id)
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
                $timestamp = strtotime($input["year"].'-'.$input['month'].'-01');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->where('events.device_id',$input['device_id'])
                                ->where('events.company_id',$this->company_id)
                                ->where('events.event_type',$input['event_type']);
                if(isset($input['client_id'])):
                    if($input['client_id']!=""):
                        $events = $events->where('events.client_id',$input['client_id']);
                    endif;
                endif;

                $events = $events->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.device_id',$input['device_id'])
                                    ->where('events.company_id',$this->company_id)
                                    ->where('events.event_type',$input['event_type']);
                if(isset($input['client_id'])):
                    if($input['client_id']!=""):
                        $events = $events->where('events.client_id',$input['client_id']);
                    endif;
                endif;

                $events = $events->skip($input['page']*$input['count'])
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
                $timestamp = strtotime($input["year"].'-'.$input['month'].'-01');
                $first = date('Y-m-01', $timestamp);
                $last  = date('Y-m-t', $timestamp);

                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                ->join('clients as c','c.client_id','events.client_id')
                                ->where('events.event_date','>=',$first)
                                ->where('events.event_date','<=',$last)
                                ->where('events.device_id',$input['device_id'])
                                ->where('events.company_id',$this->company_id)
                                ->where('events.status',$input['status']);
                if(isset($input['client_id'])):
                    if($input['client_id']!=""):
                        $events = $events->where('events.client_id',$input['client_id']);
                    endif;
                endif;

                $events = $events->skip($input['page']*$input['count'])
                    ->take($input['count'])
                    ->get();

            else:
                $events = Events::select('events.*','c.name as client_name', 'c.address as client_address')
                                    ->join('clients as c','c.client_id','events.client_id')
                                    ->where('events.device_id',$input['device_id'])
                                    ->where('events.company_id',$this->company_id)
                                    ->where('events.status',$input['status']);
                if(isset($input['client_id'])):
                    if($input['client_id']!=""):
                        $events = $events->where('events.client_id',$input['client_id']);
                    endif;
                endif;

                $events = $events->skip($input['page']*$input['count'])
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
           $check = Devices::where('device_id',$this->input['device_id'])
                        ->where('login_token',$this->input['token'])
                        ->get()->count();
            return $check;

   }

    private  function deviceDetail(){
        return Devices::where('device_id',$this->input['device_id'])
            ->where('login_token',$this->input['token'])
            ->get()->first();
    }
   private function checkRequiredParams($input,$required){
        foreach($required as $r):
            if(isset($input["$r"])==false || $r=''):
                return $r;
            endif;
        endforeach;
        return false;
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
