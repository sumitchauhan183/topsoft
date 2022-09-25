<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\InvoiceTypes;
use App\Models\Checklist;

class GeneralController extends Controller
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


    public function invoiceTypes()
    {
        $types = InvoiceTypes::where('company_id',$this->company_id)->get();
        if($types):
            return json_encode([
                'error'=>false,
                'message'=>"Invoice Types Listed",
                'data'=>$types,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"No Invoice Types found",
                'data'=>(object) [],
                'code'=>201
            ]);
        endif;
    }

    public function checklists(){
        $types = Checklist::where('company_id',$this->company_id)->get();
        if($types):
            return json_encode([
                'error'=>false,
                'message'=>"Checklist items Listed",
                'data'=>$types,
                'code'=>200
            ]);
        else:
            return json_encode([
                'error'=>true,
                'message'=>"No items in checklist found",
                'data'=>(object) [],
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

}
