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
use PDF;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    private $input;
    private $company_id;
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
        else:
            $device = $this->deviceDetail();
            $this->company_id = $device->company_id;
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
            $invoices = Invoices::where('invoice_id',$input['invoice_id'])
                ->join('clients as c','invoices.client_id','c.client_id')
                ->select('invoices.*','c.name as client_name','c.discount as client_discount')
                ->get()->first();
            if($invoices):
                $invoices->item_list = DB::table('invoice_items as ii')->select('ii.*','i.name','i.price','i.description','i.vat','i.barcode','i.discount')
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
            'client_id','device_id','item_list'
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
                $vat = $this->vat($input['item_list']);
                $discount = $this->discount($input['client_id'],$subtotal+$vat);
                $finalTotal = ($subtotal+$vat)-$discount;
                $this->subquantity($input['item_list']);
                $invoice = Invoices::create([
                    'client_id' => $input['client_id'],
                    'device_id' => $input['device_id'],
                    'company_id' => $this->company_id,
                    'type' => $input['type'],
                    'payment_method' => $input['payment_method'],
                    'address' => $input['address'],
                    'maintainance' => $input['maintainance'],
                    'note' => $input['note'],
                    'user_info' => $input['user_info'],
                    'sub_total' => $subtotal,
                    'discount'  => $discount,
                    'final_total' => $finalTotal,
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
                            'quantity'=>$item['quantity'],
                            'company_id' => $this->company_id,
                            'client_id' => $input['client_id']
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
                $inv = Invoices::where('invoice_id',$input['invoice_id'])->get()->first();
                $subtotal = $this->subtotal($input['item_list']);
                $vat = $this->vat($input['item_list']);
                $discount = $this->discount($inv->client_id,$subtotal+$vat);
                $finalTotal = ($subtotal+$vat)-$discount;
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
                    'final_total' => $finalTotal,
                    'status' => $input['status']
                ]);
                if($invoice):
                    $prevItems = InvoiceItems::where('invoice_id',$input['invoice_id'])->get()->toArray();
                    $this->addquantity($prevItems);
                    InvoiceItems::where('invoice_id',$input['invoice_id'])->delete();
                    $inv = Invoices::where('invoice_id',$input['invoice_id'])->get()->first();
                    foreach($input['item_list'] as $item):
                        InvoiceItems::create([
                            'invoice_id'=>$input['invoice_id'],
                            'item_id'=>$item['item_id'],
                            'quantity'=>$item['quantity'],
                            'company_id' => $this->company_id,
                            'client_id' => $inv->client_id
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
                ->where('invoices.company_id',$this->company_id)
                ->skip($input['page']*$input['count'])
                ->take($input['count'])
                ->select('invoices.*','c.name as client_name','c.discount as client_discount')
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

    public function delete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'invoice_id'
        ]);
        if(!$required):
            $invoices = Invoices::where('invoice_id',$input['invoice_id'])->delete();
            $items = InvoiceItems::where('invoice_id',$input['invoice_id'])->get();
            $this->addquantity($items);
            InvoiceItems::where('invoice_id',$input['invoice_id'])->delete();
            if($invoices):
                return json_encode([
                    'error'=>false,
                    'message'=>"Invoice removed successfully",
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"sever issue invoice not removed",
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
    public function multidelete(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'invoice_ids'
        ]);
        if(!$required):
            $multiinvoices = explode(',',$input['invoice_ids']);
            foreach ($multiinvoices as $i):
                Invoices::where('invoice_id',$i)->delete();
                $items = InvoiceItems::where('invoice_id',$i)->get();
                $this->addquantity($items);
                InvoiceItems::where('invoice_id',$i)->delete();
            endforeach;
            return json_encode([
                    'error'=>false,
                    'message'=>"Invoice's removed successfully",
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoicePDF()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'invoice_id'
        ]);
        if(!$required):
            $invoices = Invoices::where('invoice_id',$input['invoice_id'])->get()->first();
            if($invoices):
                $invoices->item_list = DB::table('invoice_items as ii')
                    ->select('ii.*','i.name','i.description','i.vat','i.barcode','i.discount','i.price','i.final_price')
                    ->where('ii.invoice_id',$input['invoice_id'])
                    ->join('items as i', 'ii.item_id','i.item_id')->get();
                $invoices->client = DB::table('clients')->where('client_id',$invoices->client_id)->get()->first();
                $invoices->company = DB::table('company')->where('company_id',$invoices->company_id)->get()->first();
                if(isset($input['greek'])):
                    $pdf = PDF::loadView('pdf/invoice_greek', ['data'=>$invoices]);
                else:
                    $pdf = PDF::loadView('pdf/invoice', ['data'=>$invoices]);
                endif;


                return $pdf->download('invoice.pdf');

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

    private function discount($client,$total){

        $client = Clients::where('client_id',$client)->get()->first();

            $discount = ($client->discount/100)*$total;


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

    private  function deviceDetail(){
        return Devices::where('device_id',$this->input['device_id'])
            ->where('login_token',$this->input['token'])
            ->get()->first();
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
