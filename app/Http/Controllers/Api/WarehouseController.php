<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Warehouse;

class WarehouseController extends Controller
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

    public function items(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'device_id'
        ]);
        if(!$required):
            $items = Warehouse::select('warehouse.warehouse_id','warehouse.quantity as warehouse_quantity','i.*')
                                    ->where('warehouse.device_id',$this->input['device_id'])
                                    ->where('warehouse.updated_at',">=",date('Y-m-d 00:00:00'))
                                    ->where('warehouse.updated_at',"<=",date('Y-m-d 23:59:59'))
                                    ->join('items as i','i.item_id','warehouse.item_id')
                                    ->get()->toArray();
                if(count($items)>0):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Successfully listed",
                        'data' => $items,
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"No items exist in your warehouse",
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

    public function addItems(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'device_id','items'
        ]);
        if(!$required):
            $items = $this->input['items'];
                if(count($items)>0):
                    foreach ($items as $i):
                        $this->addItemInWarehouse((object)$i);
                    endforeach;
                    return json_encode([
                        'error'=>false,
                        'message'=>"Items added in inventory",
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"No items in items array",
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


    public function removeItems(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'device_id','items'
        ]);
        if(!$required):
            $items = $this->input['items'];
            foreach ($items as $i):
                $this->removeItemFromWarehouse((object)$i);
            endforeach;
            return json_encode([
                'error'=>true,
                'message'=>"Items removed from inventory",
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

    private function addItemInWarehouse($item)
    {
        $device_id = $this->input['device_id'];
        $item_id = $item->item_id;
        $check = Warehouse::where('device_id',$device_id)
                            ->where('item_id',$item_id)
                            ->get()
                            ->first();
        if($check):
            Warehouse::where('warehouse_id',$check->warehouse_id)
                        ->update([
                            "quantity" => $item->quantity,
                            "updated_at" => date('Y-m-d')
                        ]);
        else:
            Warehouse::create([
                    "item_id" => $item_id,
                    "device_id" => $device_id,
                    "quantity" => $item->quantity,
                    "updated_at" => date('Y-m-d')
                ]);
        endif;
    }

    private function removeItemFromWarehouse($item)
    {
        $device_id = $this->input['device_id'];
        $item_id = $item->item_id;
        Warehouse::where('device_id',$device_id)
            ->where('item_id',$item_id)
            ->delete();
    }


}
