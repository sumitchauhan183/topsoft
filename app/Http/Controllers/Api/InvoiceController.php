<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Items;
use App\Models\Company;
use App\Models\Clients;
use DB;
use Exception;

class InvoiceController extends Controller
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

    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id','device_id','company_id','item_list'
        ]);
        if(!$required):
            foreach($input['item_list'] as $item):
                $required = $this->checkRequiredParams($item,[
                    'item_id','quantity'
                ]);
            endforeach;
            if(!$required):
            	$input = $this->SetColumnsToBlank($input,[
                    'type','payment_method','address','maintainance','note','user_info'
                ]);	
                $subtotal = $this->subtotal($input['item_list']);
                $discount = $this->discount($input['item_list']);
                $vat = $this->vat($input['item_list']);
                $this->subquantity($input['item_list']); 
                $invoice = Invoices::create([
                        'client_id' => $input['client_id'],
                        'device_id' => $input['device_id'],
                        'company_id' => $input['company_id'],
                        'type' => $input['type'],
                        'payment_method' => $input['payment_method'],
                        'address' => $input['address'],
                        'maintainance' => $input['maintainance'],
                        'note' => $input['note'],
                        'user_info' => $input['user_info'],
                        'sub_total' => $subtotal,
                        'discount'  => $discount,
                        'vat'       => $vat,
                        'status' => $input['status']
                ]);
                if($invoice):
                    $invoiceNumber = $this->generateInvoiceNumber($invoice);
                    Invoices::where('invoice_id',$invoice->id)->update([
                        'invoice_number' => $invoiceNumber
                    ]);
                    foreach($input['item_list'] as $item):
                        InvoiceItems::create([
                            'invoice_id'=>$invoice->id,
                            'item_id'=>$item['item_id'],
                            'quantity'=>$item['quantity']
                        ]);
                    endforeach;
                    return json_encode([
                        'error'=>false,
                        'message'=>"Invoice created successfully",
                        'code'=>201
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
                    'message'=>"$required is required key",
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
            'invoice_id','item_list'
        ]);
        if(!$required):
            foreach($input['item_list'] as $item):
                $required = $this->checkRequiredParams($item,[
                    'item_id','quantity'
                ]);
            endforeach;
            if(!$required):
            $input = $this->SetColumnsToBlank($input,[
                'type','payment_method','address','maintainance','note','user_info'
            ]);		
                $subtotal = $this->subtotal($input['item_list']);
                $discount = $this->discount($input['item_list']);
                $vat = $this->vat($input['item_list']);
            $this->subquantity($input['item_list']);							
            $invoice = Invoices::where('invoice_id',$input['invoice_id'])->update([
                'type' => $input['type'],
                'payment_method' => $input['payment_method'],
                'address' => $input['address'],
                'maintainance' => $input['maintainance'],
                'note' => $input['note'],
                'user_info' => $input['user_info'],
                'sub_total' => $subtotal,
                        'discount'  => $discount,
                        'vat'       => $vat,
                'status' => $input['status']
            ]);
            if($invoice):
                $prevItems = InvoiceItems::where('invoice_id',$input['invoice_id'])->get()->toArray();
                $this->addquantity($prevItems);
                InvoiceItems::where('invoice_id',$input['invoice_id'])->delete();
                foreach($input['item_list'] as $item):
                    InvoiceItems::create([
                        'invoice_id'=>$input['invoice_id'],
                        'item_id'=>$item['item_id'],
                        'quantity'=>$item['quantity']
                    ]);
                endforeach;
                return json_encode([
                    'error'=>false,
                    'message'=>"Invoice update successfully",
                    'code'=>201
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
                'message'=>"$required is required key",
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
            $invoices = Invoices::where('invoices.device_id',$input['device_id'])
                                  ->join('clients as c','invoices.client_id','c.client_id')  
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

    public function itemQuantityUpdate(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'invoice_item_id', 'quantity'
        ]);
        if(!$required):
            if($input['quantity']):
                InvoiceItems::where('invoice_item_id',$input['invoice_item_id'])->update([
                    "quantity"=>$input['quantity']
                ]);
                return json_encode([
                    'error'=>false,
                    'message'=>"quantity updated",
                    'code'=>200
                ]);
            else:
                InvoiceItems::where('invoice_item_id',$input['invoice_item_id'])->delete();
                return json_encode([
                    'error'=>false,
                    'message'=>"Item removed",
                    'code'=>200
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

    private function addquantity($items){
        foreach($items as $item):
            $q = Items::where('item_id',$item['item_id'])->get()->first();
            Items::where('item_id',$item['item_id'])->update(['quantity'=>$q->quantity+$item['quantity']]);
        endforeach;
    }

    private function subquantity($items){
        foreach($items as $item):
            $q = Items::where('item_id',$item['item_id'])->get()->first();
            Items::where('item_id',$item['item_id'])->update(['quantity'=>$q->quantity-$item['quantity']]);
        endforeach;
    }

    private function subtotal($item){
        $subtotal = 0;
        foreach($item as $i):
            $d = Items::where('item_id',$i['item_id'])->get()->first();
            $subtotal += $i['quantity']*$d->price;
        endforeach;

        return $subtotal;
    }

    private function discount($item){
        $discount = 0;
        foreach($item as $i):
            $d = Items::where('item_id',$i['item_id'])->get()->first();
            $discount += ($d->discount/100)*($d->price*$i['quantity']);
        endforeach;

        return $discount;
    }

    private function vat($item){
        $vat = 0;
        foreach($item as $i):
            $d = Items::where('item_id',$i['item_id'])->get()->first();
            $vat += ($d->vat/100)*($d->price*$i['quantity']);
        endforeach;

        return $vat;
    }



   private function checkToken(){
           $check = Devices::where('device_id',$this->input['device_id'])
                        ->where('login_token',$this->input['token'])
                        ->get()->count();   
            return $check;                    
        
   }

   private function generateInvoiceNumber($invoice){
        $company = Company::where('company_id',$invoice->company_id)->get()->first();

        $name = strtoupper(substr($company->name, 0, 3));
        $id = str_pad($invoice->id, 6, '0', STR_PAD_LEFT);
        return $name.'INV'.$invoice->company_id.$id;
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
