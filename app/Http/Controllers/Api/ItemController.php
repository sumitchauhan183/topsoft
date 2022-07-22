<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Items;
use Exception;

class ItemController extends Controller
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

    public function detail(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'item_id'
        ]);
        if(!$required):
            $item = Items::where('item_id',$input['item_id'])->get()->first();
            if($item):
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $item,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid item id",
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

    public function detailByBarcode(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'barcode'
        ]);
        if(!$required):
            $item = Items::where('company_id',$this->company_id)->where('barcode',$input['barcode'])->get()->first();
            if($item):
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $item,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid barcode",
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
            $items = Items::where('company_id',$this->company_id)->skip($input['page']*$input['count'])->take($input['count'])->get();
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $items,
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

    private function generateToken($id)
    {
        return  md5($id.time());
    }


}
