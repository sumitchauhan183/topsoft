<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Items;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class ItemsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

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



    public function add(Request $request)
    {
        $input = $request->all();
        $checkbc = Items::where('barcode',$input["barcode"])
                        ->where('company_id',$input["company_id"])
                        ->get()->count();
        if($checkbc<1):
            $data = [
                "company_id" => $input["company_id"],
                "name" => $input["name"],
                "quantity" => $input["quantity"],
                "price" => $input["price"],
                "description" => $input["description"],
                "vat" => $input["vat"],
                "discount" => $input["discount"],
                "status" => $input["status"],
                "barcode" => $input["barcode"],
                "final_price" => $input['price'] + (($input['price']-($input['price']*($input['discount']/100)))*($input['vat']/100)) - ($input['price']*($input['discount']/100))
            ];
            try{
                $item = Items::create($data);
                if($item):
                    //$barcode = $this->generateBarcode($item);
                    //Items::where('item_id',$item->id)->update(['barcode'=>$barcode]);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Item created successfully",
                        'code'=>201
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue item not created",
                        'code'=>201
                    ]);
                endif;
                return json_encode([
                    'error'=>false,
                    'message'=>'Item created successfully.'
                ]);
            }catch(Exception $e){
                return json_encode([
                    'error'=>true,
                    'message'=>json_encode($e),
                    'exception'=> $e
                ]);
            }
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'Barcode already used for another item'
                ]);
        endif;
    }

    public function update(Request $request)
    {
        $input     = $request->all();
        $item_id = $input['item_id'];
        $checkbc = Items::where('barcode',$input["barcode"])
            ->where('company_id',$input["company_id"])
            ->where('item_id','!=',$item_id)
            ->get()->count();
        if($checkbc<1):
        $data = [
            "company_id" => $input["company_id"],
            "name" => $input["name"],
            "quantity" => $input["quantity"],
            "price" => $input["price"],
            "description" => $input["description"],
            "vat" => $input["vat"],
            "discount" => $input["discount"],
            "status" => $input["status"],
            "barcode" => $input["barcode"],
            "final_price" => $input['price'] + (($input['price']-($input['price']*($input['discount']/100)))*($input['vat']/100)) - ($input['price']*($input['discount']/100))
        ];
       try{
        $item =  Items::where('item_id',$item_id)->update($data);
        return json_encode([
            'error'=>false,
            'message'=>'Item updated successfully.'
        ]);
       }catch(Exception $e){
        return json_encode([
            'error'=>true,
            'message'=>'Exception occured.',
            'exception'=> $e
        ]);
       }
else:
    return json_encode([
        'error'=>true,
        'message'=>'Barcode already used for another item'
    ]);
    endif;
    }

    public function list(Request $request)
    {
        $input     = $request->all();
        try{

            $id = $input['id'];
            if($id=='all'):
                $items = Items::join('company as c','items.company_id','c.company_id')
                                    ->select('items.*','c.name as company_name')
                                    ->get()
                                    ->toArray();
            else:
                $items = Items::join('company as c','items.company_id','c.company_id')
                                    ->select('items.*','c.name as company_name')
                                    ->where('items.company_id',$id)
                                    ->get()
                                    ->toArray();
            endif;

            return json_encode([
                'error'=>false,
                'message'=>'Item list',
                'items'=> $items
            ]);
        }
        catch(Excepyion $e){
            return json_encode([
                'error'=>true,
                'message'=>'Exception occured.',
                'exception'=> $e
            ]);
        }


    }

    private function generateBarcode($item){
        $name = substr($item->name, 0, 3);
        $id = $item->id;
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randInt = substr(str_shuffle($permitted_chars),0, 6);


        return $name.$id.$randInt;
   }
}
