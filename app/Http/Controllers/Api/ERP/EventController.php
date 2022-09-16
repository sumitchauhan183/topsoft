<?php

namespace App\Http\Controllers\Api\ERP;

use App\Models\Company;
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

    public function listbycompany(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                        $events = Events::select('events.*')
                            ->where('events.company_id',$input['company_id'])
                            ->skip($input['page']*$input['count'])
                            ->take($input['count'])
                            ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $events,
                        'code'=>200
                    ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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


    public function listbyclient(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):

                            $events = Events::select('events.*')
                                ->where('events.client_id',$input['client_id'])
                                ->skip($input['page']*$input['count'])
                                ->take($input['count'])
                                ->get();
                        return json_encode([
                            'error'=>false,
                            'message'=>"listing done",
                            'data'=> $events,
                            'code'=>200
                        ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Client not exists",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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

    public function listbydevice(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkDevice($input)):

                        $events = Events::select('events.*')
                                        ->where('events.device_id',$input['device_id'])
                                        ->skip($input['page']*$input['count'])
                                        ->take($input['count'])
                                        ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $events,
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Device not exists",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
                    'code'=>202
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

    private function checkCompany($company_id){
        return Company::where('company_id',$company_id)->get()->count();
    }

    private function checkClient($input){
        return Clients::where('client_id',$input['client_id'])
                   ->where('company_id',$input['company_id'])
                   ->get()->count();
    }

    private function checkDevice($input){
        return Devices::where('device_id',$input['device_id'])
            ->where('company_id',$input['company_id'])
            ->get()->count();
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
