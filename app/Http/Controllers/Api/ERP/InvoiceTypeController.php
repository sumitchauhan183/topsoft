<?php

namespace App\Http\Controllers\Api\ERP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Chat;
use App\Models\Company;
use Exception;

class InvoiceTypeController extends Controller
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
            'device_id','company_id','message'
        ]);
        if(!$required):
            $chat = Chat::create([
                'company_id'  => $input['company_id'],
                'device_id'   => $input['device_id'],
                'message'     => $input['message'],
                'status'      => "send",
                'sent_by'     => "company"
            ]);
            if($chat):
                return json_encode([
                    'error'=>false,
                    'message'=>"Message sent successfully",
                    'data'=>(object)[],
                    'code'=>201
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"server issue message not sent",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;

    }

    public function update(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id','page','count'
        ]);
        if(!$required):
            $chat  = Chat::where('device_id',$input['device_id'])
                ->where('company_id',$input['company_id'])
                ->where('company_delete',0)
                ->skip($input['page']*$input['count'])
                ->take($input['count'])
                ->orderBy('chat_id','DESC')
                ->get();
            return json_encode([
                'error'=>false,
                'message'=>"Messages List",
                'data'=>$chat,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;
    }

    public function detail(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id','page','count'
        ]);
        if(!$required):
            $chat  = Chat::where('device_id',$input['device_id'])
                ->where('company_id',$input['company_id'])
                ->where('company_delete',0)
                ->skip($input['page']*$input['count'])
                ->take($input['count'])
                ->orderBy('chat_id','DESC')
                ->get();
            return json_encode([
                'error'=>false,
                'message'=>"Messages List",
                'data'=>$chat,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;
    }

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id','page','count'
        ]);
        if(!$required):
            $chat  = Chat::where('device_id',$input['device_id'])
                ->where('company_id',$input['company_id'])
                ->where('company_delete',0)
                ->skip($input['page']*$input['count'])
                ->take($input['count'])
                ->orderBy('chat_id','DESC')
                ->get();
            return json_encode([
                'error'=>false,
                'message'=>"Messages List",
                'data'=>$chat,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;
    }

    public function delete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','device_id','chat_id'
        ]);
        if(!$required):
            $chat  = Chat::where('chat_id',$input['chat_id'])
                ->where('company_id',$input['company_id'])
                ->where('device_id',$input['device_id'])
                ->update(['company_delete'=>1]);
            if($chat):
                return json_encode([
                    'error'=>false,
                    'message'=>"message deleted",
                    'data'=>(object)[],
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid chat_id, company_id or device_id",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=>(object)[],
                'data'=>(object)[],
                'code'=>201
            ]);
        endif;
    }

    private function checkToken(){
        $token = $this->input['token'];
        if(env('erp_token')!=$token):
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
