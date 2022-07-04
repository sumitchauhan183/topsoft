<?php

namespace App\Http\Controllers\Api\ERP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\Clients;
use App\Models\Invoices;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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

    public function invoices(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id'
        ]);
        if(!$required):
            $client = Invoices::where('client_id',$input['client_id'])->get();
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $client,
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

    public function detail(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'client_id','company_id'
        ]);
        if(!$required):
            $client = Clients::where('client_id',$input['client_id'])
                ->where('company_id',$input['company_id'])->get()->first();
            if($client):
                return json_encode([
                    'error'=>false,
                    'message'=>"details listed",
                    'data'=> $client,
                    'code'=>200
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"Invalid client id or company id",
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

    public function add()
    {
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','name','address','city','postal_code','telephone','mobile','tax_number','occupation',
            'email','payment_mode'
        ]);
        if(!$required):
            $check = Clients::where('email',$input['email'])->get()->count();
            if(!$check):
                $input = $this->SetColumnsToBlank($input,[
                    'region','tax_post','discount','note','note2','latitude','longitude'
                ]);
                $client = Clients::create([
                    'company_id'=>$input['company_id'],
                        'name' => $input['name'],
                        'region' => $input['region'],
                        'address' => $input['address'],
                        'city' => $input['city'],
                        'postal_code' => $input['postal_code'],
                        'telephone' => $input['telephone'],
                        'mobile' => $input['mobile'],
                        'tax_number' => $input['tax_number'],
                        'tax_post' => $input['tax_post'],
                        'occupation' => $input['occupation'],
                        'email' => $input['email'],
                        'discount' => $input['discount'],
                        'note' => $input['note'],
                        'note2' => $input['note2'],
                        'payment_mode' => $input['payment_mode'],
                        'latitude' => $input['latitude'],
                        'longitude'   => $input['longitude']

                ]);
                if($client):
                    $client->client_id = $client->id;
                    unset($client->id);
                    return json_encode([
                        'error'=>false,
                        'message'=>"Customer created successfully",
                        'code'=>200,
                        'data'=>$client
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue customer not created",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"email already use for another customer",
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

    public function update(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','client_id','name','address','city','postal_code','telephone','mobile','tax_number','occupation',
            'email','payment_mode'
        ]);
        if(!$required):
            $check  = Clients::where('email',$input['email'])
                            ->where('client_id','!=',$input['client_id'])
                            ->get()->count();
            if(!$check):
                $input = $this->SetColumnsToBlank($input,[
                    'region','tax_post','discount','note','note2','latitude','longitude'
                ]);
                $client = Clients::where('client_id',$input['client_id'])
                    ->where('company_id',$input['company_id'])->update([
                    'name' => $input['name'],
                    'region' => $input['region'],
                    'address' => $input['address'],
                    'city' => $input['city'],
                    'postal_code' => $input['postal_code'],
                    'telephone' => $input['telephone'],
                    'mobile' => $input['mobile'],
                    'tax_number' => $input['tax_number'],
                    'tax_post' => $input['tax_post'],
                    'occupation' => $input['occupation'],
                    'email' => $input['email'],
                    'discount' => $input['discount'],
                    'note' => $input['note'],
                    'note2' => $input['note2'],
                    'payment_mode' => $input['payment_mode'],
                    'latitude' => $input['latitude'],
                    'longitude'   => $input['longitude']
                ]);

                if($client):
                    return json_encode([
                        'error'=>false,
                        'message'=>"Details updated successfully",
                        'code'=>200
                    ]);
                else:
                    return json_encode([
                        'error'=>true,
                        'message'=>"server issue client not created",
                        'code'=>203
                    ]);
                endif;
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>"email already use for another client",
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

    public function list(Request $request){
        $input = $this->input;
        $required = $this->checkRequiredParams($input,[
            'company_id','page','count'
        ]);
        if(!$required):
            $clients = Clients::where('company_id',$input['company_id'])->skip($input['page']*$input['count'])->take($input['count'])->get();
            return json_encode([
                'error'=>false,
                'message'=>"listing done",
                'data'=> $clients,
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
            'company_id','client_id'
        ]);
        if(!$required):
            DB::beginTransaction();

            try {

                DB::table('clients')->where('company_id',$input['company_id'])
                    ->where('client_id',$input['client_id'])->delete();
                DB::table('invoices')->where('company_id',$input['company_id'])
                    ->where('client_id',$input['client_id'])->delete();
                DB::table('receipts')->where('company_id',$input['company_id'])
                    ->where('client_id',$input['client_id'])->delete();
                DB::table('events')->where('company_id',$input['company_id'])
                    ->where('client_id',$input['client_id'])->delete();
                DB::table('invoice_items')->where('company_id',$input['company_id'])
                    ->where('client_id',$input['client_id'])->delete();
                DB::commit();
                return json_encode([
                    'error'=>false,
                    'message'=>"Customer deleted successfully",
                    'data'=> (object)[],
                    'code'=>200
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                return json_encode([
                    'error'=>false,
                    'message'=>"Something went wrong",
                    'data'=> $e,
                    'code'=>202
                ]);
            }

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
     foreach($required as $r):
         if(isset($input["$r"])==false):
             $input["$r"] = '';
         endif;
     endforeach;
     return $input;
 }

}
