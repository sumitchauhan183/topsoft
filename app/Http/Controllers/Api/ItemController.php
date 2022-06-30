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
            $item = Items::where('barcode',$input['barcode'])->get()->first();
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

    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'name','quantity','price','description','vat','discount','final_price'
        ]);
        if(!$required):
            $check = Items::where('name',$input['name'])->get()->count();
            if(!$check):
                $item = Items::create([
                        'name' => $input['name'],
                        'quantity' => $input['quantity'],
                        'price' => $input['price'],
                        'description'=> $input['description'],
                        'vat' => $input['vat'],
                        'discount'=> $input['discount'],
                        'final_price' => $input['price']
                ]);
                if($item):
                    $barcode = $this->generateBarcode($item);
                    Items::where('item_id',$item->id)->update(['barcode'=>$barcode]);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Item created successfully",
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue item not created",
                        'code'=>201
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Item alredy in item list with same name",
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
            'name','quantity','price','description','vat','discount','final_price','item_id'
        ]);
        if(!$required):
            $check  = Items::where('name',$input['name'])
                            ->where('item_id','!=',$input['item_id'])
                            ->get()->count();
            if(!$check):
                
                $item = Items::where('item_id',$input['item_id'])->update([
                        'name' => $input['name'],
                        'quantity' => $input['quantity'],
                        'price' => $input['price'],
                        'description'=> $input['description'],
                        'vat' => $input['vat'],
                        'discount'=> $input['discount'],
                        'final_price' => $input['price']
                ]);
                
                if($item):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Details updated successfully",
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
                    'message'=>"Item already exist with same name",
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
            $items = Items::skip($input['page']*$input['count'])->take($input['count'])->get();
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

    public function delete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id'
        ]);
        if(!$required):
            $client = Clients::where('client_id',$input['client_id'])->delete();
            if($client):
                return json_encode([
                    'error'=>false,
                    'message'=>"client removed successfully",
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

   private function generateBarcode($item){
        $name = substr($item->name, 0, 3);
        $id = $item->id;
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randInt = substr(str_shuffle($permitted_chars),0, 6);


        return $name.$id.$randInt;
   }

   private function checkToken(){
           $check = Devices::where('device_id',$this->input['device_id'])
                        ->where('login_token',$this->input['token'])
                        ->get()->count();   
            return $check;              
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
