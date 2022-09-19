<?php

namespace App\Http\Controllers\Api\ERP;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\Clients;
use App\Models\Receipts;
use App\Models\Events;
use App\Models\Items;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
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



    public function invoices(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','last_updated'
        ]);
        if(!$required):
            $last = date('Y-m-d H:i:s',strtotime($input['last_updated']));
            if($this->checkCompany($input['company_id'])):
                $invoicesDetails = [];
                    $invoices = Invoices::join('clients as c','invoices.client_id','c.client_id')
                        ->where('invoices.company_id',$input['company_id'])
                        ->where('invoices.updated_at','>',$last)
                        ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                        ->get();
                    if(count($invoices)>0):
                    foreach ($invoices as $in):
                        $in->item_list = DB::table('invoice_items as ii')->select('ii.*','i.name','i.price','i.description','i.vat','i.barcode','i.discount')
                            ->where('ii.invoice_id',$in->invoice_id)
                            ->join('items as i', 'ii.item_id','i.item_id')->get();
                        array_push($invoicesDetails, $in);
                    endforeach;
                    endif;
                    return json_encode([
                        'error'=>false,
                        'message'=>"listing done",
                        'data'=> $invoicesDetails,
                        'code'=>200
                    ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
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
    public function customers(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','last_updated'
        ]);
        if(!$required):
            $last = date('Y-m-d H:i:s',strtotime($input['last_updated']));
            if($this->checkCompany($input['company_id'])):
                $clients = Clients::where('company_id',$input['company_id'])
                    ->where('updated_at','>',$last)
                    ->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"listing done",
                    'data'=> $clients,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
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
    public function receipts(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','last_updated'
        ]);
        if(!$required):
            $last = date('Y-m-d H:i:s',strtotime($input['last_updated']));
            if($this->checkCompany($input['company_id'])):
                $receipts = Receipts::where('company_id',$input['company_id'])
                    ->where('updated_at','>',$last)
                    ->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"listing done",
                    'data'=> $receipts,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
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
    public function events(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','last_updated'
        ]);
        if(!$required):
            $last = date('Y-m-d H:i:s',strtotime($input['last_updated']));
            if($this->checkCompany($input['company_id'])):
                $events = Events::where('company_id',$input['company_id'])
                    ->where('updated_at','>',$last)
                    ->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"listing done",
                    'data'=> $events,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
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
    public function items(){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','last_updated'
        ]);
        if(!$required):
            $last = date('Y-m-d H:i:s',strtotime($input['last_updated']));
            if($this->checkCompany($input['company_id'])):
                $items = Items::where('company_id',$input['company_id'])
                    ->where('updated_at','>',$last)
                    ->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"listing done",
                    'data'=> $items,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Company not exists",
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
    private function checkCompany($company_id){
        return Company::where('company_id',$company_id)->get()->count();
    }

    private function checkClient($input){
        return Clients::where('client_id',$input['client_id'])
                   ->where('company_id',$input['company_id'])
                   ->get()->count();
    }

    private function checkDevice($input){
        return Devices::where('device_id',$input['device_id'])
            ->where('company_id',$input['company_id'])
            ->get()->count();
    }

    private function checkToken(){
        $token = $this->input['token'];
        if(env('erp_token'!=$token)):
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

    private function SetColumnsToBlank($input,$required){
     foreach($required as $r):
         if(isset($input["$r"])==false):
             $input["$r"] = '';
         endif;
     endforeach;
     return $input;
 }

}
