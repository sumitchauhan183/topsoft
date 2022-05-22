<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receipts;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class ReceiptController extends Controller
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


    public function list(Request $request)
    {
        $input     = $request->all();
        try{
            $id = $input['id'];
            if($id=='all'):
                $receipts = Receipts::join('company as c','receipts.company_id','c.company_id')
                                    ->join('clients as cl','receipts.client_id','cl.client_id')
                                    ->select('receipts.*','c.name as company_name','cl.name as client_name')
                                    ->get()
                                    ->toArray();
            else:
                $receipts = Receipts::join('company as c','receipts.company_id','c.company_id')
                                    ->join('clients as cl','receipts.client_id','cl.client_id')
                                    ->select('receipts.*','c.name as company_name','cl.name as client_name')
                                    ->where('receipts.company_id',$id)
                                    ->get()
                                    ->toArray();
            endif;
            
        
            return json_encode([
                'error'=>false,
                'message'=>'receipt list',
                'receipts'=> $receipts
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