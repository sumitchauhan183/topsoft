<?php

namespace App\Http\Controllers\Api\ERP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
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

    public function detail(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'item_id','company_id'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $item = Items::where('company_id',$input['company_id'])
                ->where('item_id',$input['item_id'])
                ->get()
                ->first();
            if($item):
                return json_encode([
                    'error'=>false,
                    'message'=>"Item details listed",
                    'data'=> $item,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid item id",
                    'data'=> (object)[],
                    'code'=>203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
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

    public function detailByBarcode(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'barcode','company_id'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $item = Items::where('barcode',$input['barcode'])->get()->first();
            if($item):
                return json_encode([
                    'error'=>false,
                    'message'=>"item details listed",
                    'data'=> $item,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid barcode",
                    'data'=> (object)[],
                    'code'=>203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=> (object)[],
                'code'=>201
            ]);
        endif;
    }

    public function add(Request $request)
    {
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'company_id','name','quantity','price','description','vat','discount','barcode'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $check = Items::where('name',$input['name'])->where('company_id',$input['company_id'])->get()->count();
            if(!$check):
                $item = Items::create([
                        'company_id' => $input['company_id'],
                        'name' => $input['name'],
                        'quantity' => $input['quantity'],
                        'price' => $input['price'],
                        'description'=> $input['description'],
                        'vat' => $input['vat'],
                        'discount'=> $input['discount'],
                        'barcode'=> $input['barcode'],
                        'final_price' => $input['price'] + (($input['price']-($input['price']*($input['discount']/100)))*($input['vat']/100)) - ($input['price']*($input['discount']/100))
                ]);
                if($item):
                    //$barcode = $this->generateBarcode($item);
                    //Items::where('item_id',$item->id)->update(['barcode'=>$barcode]);
                    $item->item_id = $item->id;
                    unset($item->id);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Item created successfully",
                        'code'=>200,
                        'data'=>$item
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue item not created",
                        'data'=> (object)[],
                        'code'=>204
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Item alredy in item list with same name",
                    'data'=> (object)[],
                    'code'=>203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=> (object)[],
                'code'=>201
            ]);
        endif;

    }

    public function update(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
           'company_id', 'name','quantity','price','description','vat','discount','item_id','barcode'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $check  = Items::where('name',$input['name'])
                            ->where('item_id','!=',$input['item_id'])
                            ->where('company_id','==',$input['company_id'])
                            ->get()->count();
            if(!$check):

                $item = Items::where('item_id',$input['item_id'])
                         ->where('company_id',$input['company_id'])->update([
                        'name' => $input['name'],
                        'quantity' => $input['quantity'],
                        'price' => $input['price'],
                        'description'=> $input['description'],
                        'vat' => $input['vat'],
                        'discount'=> $input['discount'],
                        'barcode'=> $input['barcode'],
                        'final_price' => $input['price'] + (($input['price']-($input['price']*($input['discount']/100)))*($input['vat']/100)) - ($input['price']*($input['discount']/100))
                ]);

                if($item):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Item updated successfully",
                        'data'=> (object)[],
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue item not updated",
                        'data'=> (object)[],
                        'code'=>204
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Item already exist with same name",
                    'data'=> (object)[],
                    'code'=>203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=> (object)[],
                'code'=>201
            ]);
        endif;
    }

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','page','count'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $items = Items::where('company_id',$input['company_id'])
                            ->skip($input['page']*$input['count'])
                            ->take($input['count'])
                            ->get();
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $items,
                'code'=>200
            ]);
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
                    'data'=>(object)[],
                    'code'=>202
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>"$required is required key",
                'data'=> (object)[],
                'code'=>201
            ]);
        endif;
    }

    public function delete(Request $request){
        $input = $request->all();
        $required = $this->checkRequiredParams($input,[
            'company_id','item_id'
        ]);
        if(!$required):
            $comCheck = Company::where('company_id',$input['company_id'])->get()->count();
            if($comCheck):
            $item = Items::where('company_id',$input['company_id'])
                        ->where('item_id',$input['item_id'])
                        ->delete();
            if($item):
                return json_encode([
                    'error'=>false,
                    'message'=>"item removed successfully",
                    'data'=>(object)[],
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"sever issue item not removed",
                    'data'=>(object)[],
                    'code'=>203
                ]);
            endif;
            else:
                return json_encode([
                    'error'=>false,
                    'message'=>"Company not exist",
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

   private function generateBarcode($item){
        $name = substr(str_shuffle(date('dmyhis')), 0, 3);
        $id = $item->id;
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $randInt = substr(str_shuffle($permitted_chars),0, 6);


        return $name.$id.$randInt;
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

    private function generateToken($id)
    {
        return  md5($id.time());
    }


}
