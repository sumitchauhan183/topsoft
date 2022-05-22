<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class InvoiceController extends Controller
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
                $invoices = Invoices::join('company as c','invoices.company_id','c.company_id')
                                    ->join('clients as cl','invoices.client_id','cl.client_id')
                                    ->select('invoices.*','c.name as company_name','cl.name as client_name')
                                    ->get()
                                    ->toArray();
            else:
                $invoices = Invoices::join('company as c','invoices.company_id','c.company_id')
                                    ->join('clients as cl','invoices.client_id','cl.client_id')
                                    ->select('invoices.*','c.name as company_name','cl.name as client_name')
                                    ->where('invoices.company_id',$id)
                                    ->get()
                                    ->toArray();
            endif;
            
        
            return json_encode([
                'error'=>false,
                'message'=>'invoice list',
                'invoices'=> $invoices
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