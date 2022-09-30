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

    public function add(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','device_id','event_type','event_date'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    if($this->checkDevice($input)):
                        $input = $this->SetColumnsToBlank($input,[
                            'observation'
                        ]);
                        if($input["event_type"]=="checklist"):
                            $data = [
                                'client_id'=>$input['client_id'],
                                'company_id'=>$input['company_id'],
                                'device_id'=>$input['device_id'],
                                'event_type' => $input['event_type'],
                                'observation' => $input['observation'],
                                'checklist' => json_encode($input['checklist']),
                                'event_date'   => date('Y-m-d',strtotime($input['event_date']))
                            ];
                        else:
                                $data = [
                                    'client_id'=>$input['client_id'],
                                    'company_id'=>$input['company_id'],
                                    'device_id'=>$input['device_id'],
                                    'event_type' => $input['event_type'],
                                    'observation' => $input['observation'],
                                    'event_date'   => date('Y-m-d',strtotime($input['event_date']))
                                ];
                        endif;
                        $events = Events::create($data);
                        if($events):
                            return json_encode([
                                'error'=>false,
                                'message'=>"Event created successfully",
                                'data'=> Events::where('event_id',$events->id)->get()->first(),
                                'code'=>200
                            ]);
                        else:
                            return json_encode([
                                'error'=>true,
                                'message'=>"server issue event not created",
                                'code'=>205
                            ]);
                        endif;
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"Device not exists",
                            'code'=>204
                        ]);
                    endif;
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
    public function update(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','device_id','event_id','event_type','event_date'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    if($this->checkDevice($input)):
                        if($this->checkEvent($input)):
                        $input = $this->SetColumnsToBlank($input,[
                            'observation','is_completed'
                        ]);
                            if($input["event_type"]=="checklist"):
                                $data = [
                                    'client_id'=>$input['client_id'],
                                    'device_id'=>$input['device_id'],
                                    'event_type' => $input['event_type'],
                                    'observation' => $input['observation'],
                                    'is_completed' => $input['is_completed'],
                                    'checklist' => json_encode($input['checklist']),
                                    'event_date'   => date('Y-m-d',strtotime($input['event_date']))
                                ];
                            else:
                                $data = [
                                    'client_id'   =>$input['client_id'],
                                    'device_id'   =>$input['device_id'],
                                    'event_type'  => $input['event_type'],
                                    'observation' => $input['observation'],
                                    'is_completed' => $input['is_completed'],
                                    'event_date'  => date('Y-m-d',strtotime($input['event_date']))
                                ];
                            endif;
                        $event = Events::where('event_id',$input['event_id'])->update($data);
                        if($event):
                            return json_encode([
                                'error'=>false,
                                'message'=>"Event updated successfully",
                                'data'=> Events::where('event_id',$input['event_id'])->get()->first(),
                                'code'=>200
                            ]);
                        else:
                            return json_encode([
                                'error'=>true,
                                'message'=>"server issue Event not created",
                                'code'=>206
                            ]);
                        endif;
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"Event not exists",
                            'code'=>205
                        ]);
                    endif;
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"Device not exists",
                            'code'=>204
                        ]);
                    endif;
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
    public function delete(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','event_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkEvent($input)):
                Events::where('company_id',$input['company_id'])->where('event_id',$input['event_id'])->delete();
                return json_encode([
                    'error'=>false,
                    'message'=>"Event removed successfully",
                    'data'=> (object) [],
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Event not exists",
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
    public function listbycompany(){
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

    public function listbyclient(){
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

    public function listbydevice(){
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

    private function checkEvent($input){
        if(isset($input['client_id']) && isset($input['device_id'])):
            return Events::where('device_id',$input['device_id'])
                ->where('client_id',$input['client_id'])
                ->where('company_id',$input['company_id'])
                ->where('event_id',$input['event_id'])
                ->get()->count();
        elseif(isset($input['device_id'])):
            return Events::where('device_id',$input['device_id'])
                ->where('company_id',$input['company_id'])
                ->where('event_id',$input['event_id'])
                ->get()->count();
        elseif(isset($input['client_id'])):
            return Events::where('client_id',$input['client_id'])
                ->where('company_id',$input['company_id'])
                ->where('event_id',$input['event_id'])
                ->get()->count();
        else:
            return Events::where('company_id',$input['company_id'])
                ->where('event_id',$input['event_id'])
                ->get()->count();
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


    private function SetColumnsToBlank($input,$required){
     foreach($required as $r):
         if(isset($input["$r"])==false):
             $input["$r"] = '';
         endif;
     endforeach;
     return $input;
 }

}
