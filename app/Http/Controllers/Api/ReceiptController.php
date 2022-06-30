<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receipts;
use App\Models\Devices;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;
use PDF;

class ReceiptController extends Controller
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
            'receipt_id'
        ]);
        if(!$required):
            $receipts = Receipts::join('clients as c','receipts.client_id','c.client_id') 
                                ->where('receipt_id',$input['receipt_id'])
                                ->select('receipts.*','c.name as client_name')
                                ->get()
                                ->first();
            if($receipts):
                
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $receipts,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid receipt id",
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
            'client_id','company_id','amount','observation','note','receipt_date'
        ]);
            if(!$required):
            	
                $receipt = Receipts::create([
                        'client_id' => $input['client_id'],
                        'company_id' => $input['company_id'],
                        'amount' => $input['amount'],
                        'observation' => $input['observation'],
                        'note' => $input['note'],
                        'receipt_date' => $input['receipt_date']
                ]);
                if($receipt):
                    $receiptNumber = $this->generateReceiptNumber($receipt);
                    Receipts::where('receipt_id',$receipt->id)->update([
                        'receipt_number' => $receiptNumber
                    ]);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Receipt created successfully",
                        'code'=>201
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue receipt not created",
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
            'receipt_id','amount','observation','note'
        ]);
            if(!$required):
            						
            $receipt = Receipts::where('receipt_id',$input['receipt_id'])->update([
                        'amount' => $input['amount'],
                        'observation' => $input['observation'],
                        'note' => $input['note'],
            ]);
            if($receipt):
                return json_encode([
                    'error'=>false,
                    'message'=>"Receipt update successfully",
                    'code'=>201
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"server issue receipt not created",
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
            $receipts = Receipts::join('clients as c','receipts.client_id','c.client_id')  
                                  ->skip($input['page']*$input['count'])
                                  ->take($input['count'])
                                  ->select('receipts.*','c.name as client_name')
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
                'message'=>"$required is required key",
                'code'=>201
            ]);
        endif;
    }

    public function delete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'receipt_id'
        ]);
        if(!$required):
            Receipts::where('receipt_id',$input['receipt_id'])  
                                  ->delete();
            return json_encode([
                'error'=>true,
                'message'=>"Receipt deleted",
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receiptPDF()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'receipt_id'
        ]);
        if(!$required):
            $receipts = Receipts::join('clients as c','receipts.client_id','c.client_id') 
                                ->where('receipt_id',$input['receipt_id'])
                                ->select('receipts.*','c.name as client_name')
                                ->get()
                                ->first();
            if($receipts):
                $pdf = PDF::loadView('pdf/receipt', ['data'=>$receipts]);
                return $pdf->download('receipt.pdf');
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid receipt id",
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

private function checkToken(){
        $check = Devices::where('device_id',$this->input['device_id'])
                     ->where('login_token',$this->input['token'])
                     ->get()->count();   
         return $check;                    
     
}

private function generateReceiptNumber($receipt){
     $company = Company::where('company_id',$receipt->company_id)->get()->first();
     $name = strtoupper(substr($company->name, 0, 3));
     $id = str_pad($receipt->id, 6, '0', STR_PAD_LEFT);
     return $name.'RCT'.$receipt->company_id.$id;
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