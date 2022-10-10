<?php

namespace App\Http\Controllers\Api\ERP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Modules;

class ModuleController extends Controller
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



    public function list(){
                    $modules = Modules::get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $modules,
                        'code'=>200
                    ]);
    }

    public function listbyclient(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                        ->where('invoices.company_id',$input['company_id'])
                        ->where('invoices.client_id',$input['client_id'])
                        ->skip($input['page']*$input['count'])
                        ->take($input['count'])
                        ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                        ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $invoices,
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
            'company_id','event_type','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                    ->where('invoices.company_id',$input['company_id'])
                    ->where('invoices.type',$input['event_type'])
                    ->skip($input['page']*$input['count'])
                    ->take($input['count'])
                    ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                    ->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"listing done",
                    'data'=> $invoices,
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

    public function listbyclientwithtype(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','event_type','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                        ->where('invoices.company_id',$input['company_id'])
                        ->where('invoices.client_id',$input['client_id'])
                        ->where('invoices.type',$input['event_type'])
                        ->skip($input['page']*$input['count'])
                        ->take($input['count'])
                        ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                        ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $invoices,
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


    public function listbystatus(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','status','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                    ->where('invoices.company_id',$input['company_id'])
                    ->where('invoices.status',$input['status'])
                    ->skip($input['page']*$input['count'])
                    ->take($input['count'])
                    ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                    ->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"listing done",
                    'data'=> $invoices,
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

    public function listbyclientwithstatus(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','status','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                        ->where('invoices.company_id',$input['company_id'])
                        ->where('invoices.client_id',$input['client_id'])
                        ->where('invoices.status',$input['status'])
                        ->skip($input['page']*$input['count'])
                        ->take($input['count'])
                        ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                        ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $invoices,
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

    public function details(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','invoice_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                $invoices = Invoices::where('invoice_id',$input['invoice_id'])
                    ->join('clients as c','invoices.client_id','c.client_id')
                    ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                    ->get()->first();
                if($invoices):
                    $invoices->item_list = DB::table('invoice_items as ii')->select('ii.*','i.name','i.price','i.description','i.vat','i.barcode','i.discount')
                        ->where('ii.invoice_id',$input['invoice_id'])
                        ->join('items as i', 'ii.item_id','i.item_id')->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"details listed",
                        'data'=> $invoices,
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Invalid invoice id",
                        'code'=>201
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
