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
        $data = [
                "company_id" => $input["company_id"],
                "name" => $input["name"],
                "quantity" => $input["quantity"],
                "price" => $input["price"],
                "description" => $input["description"],
                "vat" => $input["vat"],
                "discount" => $input["discount"],
                "status" => $input["status"],
                "barcode" => ""
        ];
       try{
        Items::create($data);
        return json_encode([
            'error'=>false,
            'message'=>'Item created successfully.'
        ]);
       }catch(Exception $e){
        return json_encode([
            'error'=>true,
            'message'=>'Exception occured.',
            'exception'=> $e
        ]);
       }
        
    } 

    public function update(Request $request)
    {
        $input     = $request->all();
        $item_id = $input['item_id'];
        $data = [
            "name" => $input["name"],
            "quantity" => $input["quantity"],
            "price" => $input["price"],
            "description" => $input["description"],
            "vat" => $input["vat"],
            "discount" => $input["discount"],
            "status" => $input["status"]
        ];
       try{
        Items::where('item_id',$item_id)->update($data);
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
}