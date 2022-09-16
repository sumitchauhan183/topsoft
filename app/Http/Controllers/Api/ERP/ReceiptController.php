<?php

namespace App\Http\Controllers\Api\ERP;

use App\Models\Company;
use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receipts;
use App\Models\Clients;
use Exception;

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
    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','amount','observation','note','receipt_date'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    $receipt = Receipts::create([
                        'client_id' => $input['client_id'],
                        'company_id' => $input['company_id'],
                        'amount' => $input['amount'],
                        'observation' => $input['observation'],
                        'note' => $input['note'],
                        'receipt_date' => date("Y-m-d",strtotime($input['receipt_date']))
                    ]);
                    if($receipt):
                        $receiptNumber = $this->generateReceiptNumber($receipt);
                        Receipts::where('receipt_id',$receipt->id)->update([
                            'receipt_number' => $receiptNumber
                        ]);
                        return json_encode([
                            'error'=>false,
                            'message'=>"Receipt created successfully",
                            'data'=> Receipts::where('receipt_number',$receiptNumber)->get(),
                            'code'=>200
                        ]);
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"server issue receipt not created",
                            'code'=>204
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Client not exists",
                        'code'=>203
                    ]);
                endif;
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
    public function update()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','receipt_id','amount','observation','note'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    if($this->checkReceipt($input)):
                    $receipt = Receipts::where('receipt_id',$input['receipt_id'])->update([
                        'amount' => $input['amount'],
                        'observation' => $input['observation'],
                        'note' => $input['note'],
                    ]);
                    if($receipt):
                        return json_encode([
                            'error'=>false,
                            'message'=>"Receipt update successfully",
                            'data'=> Receipts::where('receipt_id',$input['receipt_id'])->get(),
                            'code'=>201
                        ]);
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"server issue receipt not updated",
                            'code'=>205
                        ]);
                    endif;
                    else:
                        return json_encode([
                            'error'=>true,
                            'message'=>"Receipt not exists",
                            'code'=>204
                        ]);
                    endif;
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Client not exists",
                        'code'=>203
                    ]);
                endif;
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
    public function list()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                    $receipts = Receipts::where('company_id',$input['company_id'])
                        ->skip($input['page']*$input['count'])
                        ->take($input['count'])
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
    public function listbyclient()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','page','count'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkClient($input)):
                    $receipts = Receipts::where('company_id',$input['company_id'])
                        ->where('client_id',$input['client_id'])
                        ->skip($input['page']*$input['count'])
                        ->take($input['count'])
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
                        'message'=>"Client not exists",
                        'code'=>203
                    ]);
                endif;
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
    public function delete()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','receipt_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkReceipt($input)):
                Receipts::where('company_id',$input['company_id'])
                    ->where('receipt_id',$input['receipt_id'])
                    ->delete();
                return json_encode([
                    'error'=>false,
                    'message'=>"Receipt removed successfully",
                    'data'=> (object)[],
                    'code'=>200
                ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Receipt not exists",
                        'code'=>202
                    ]);
                endif;
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
    public function detail()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','receipt_id'
        ]);
        if(!$required):
            if($this->checkCompany($input['company_id'])):
                if($this->checkReceipt($input)):
                   $receipt = Receipts::where('company_id',$input['company_id'])
                        ->where('receipt_id',$input['receipt_id'])
                        ->get();
                    return json_encode([
                        'error'=>false,
                        'message'=>"Receipt details",
                        'data'=> $receipt,
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"Receipt not exists",
                        'code'=>203
                    ]);
                endif;
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

    private function generateReceiptNumber($receipt){
        $company = Company::where('company_id',$receipt->company_id)->get()->first();
        $name = strtoupper(substr($company->name, 0, 3));
        $id = str_pad($receipt->id, 6, '0', STR_PAD_LEFT);
        return $name.'RCT'.$receipt->company_id.$id;
    }
    private function checkCompany($company_id){
        return Company::where('company_id',$company_id)->get()->count();
    }

    private function checkClient($input){
        return Clients::where('client_id',$input['client_id'])
                   ->where('company_id',$input['company_id'])
                   ->get()->count();
    }

    private function checkReceipt($input){
        return Receipts::where('receipt_id',$input['receipt_id'])
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
