<?php

namespace App\Http\Controllers\API\ERP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Events;
use App\Models\Receipts;
use DB;
use Exception;

class ListingController extends Controller
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
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'invoice_id'
        ]);
        if(!$required):
            $invoices = Invoices::where('invoice_id',$input['invoice_id'])->get()->first();
            if($invoices):
                $invoices->item_list = DB::table('invoice_items as ii')->select('ii.*','i.name','i.description','i.vat','i.barcode','i.discount')
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
            $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                                  ->skip($input['page']*$input['count'])
                                  ->take($input['count'])
                                  ->select('invoices.*','c.name as client_name')
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
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }



    public function items(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'invoice_id'
        ]);
        if(!$required):
            $items = InvoiceItems::where('invoice_id',$input['invoice_id'])->get();
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

   private function SetColumnsToBlank($input,$required){
       $input["status"] = 'success';
    foreach($required as $r):
        if(isset($input["$r"])==false):
            $input["$r"] = '';
            $input["status"] = 'draft';
        endif;
    endforeach;
    return $input;
}


    private function generateToken($id)
    {
        return  md5($id.time());
    }


}
