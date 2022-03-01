<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Support\Facades\Hash;
use App\Classes\Email;
use Exception;

class ClientController extends Controller
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

    public function checkEmailExist(Request $request)
    {
        $input = $request->all();
        if(isset($input['email'])):
            $check = Clients::where('email',$input['email'])->count();
            if($check<1):
                return json_encode([
                    'error'=>false
                ]);
            else:
                return json_encode([
                    'error'=>true,
                    'message'=>'This email is already used by another client'
                ]);
            endif;
        else:
            return json_encode([
                'error'=>true,
                'message'=>'Email id is required'
            ]);
        endif;
    }

    public function add(Request $request)
    {
        $input = $request->all();
        $data = [
                "name" => $input["name"],
                "email" => $input["email"],
                "mobile" => $input["mobile"],
                "telephone" => $input["telephone"],
                "address" => $input["address"],
                "city" => $input["city"],
                "region" => $input["region"],
                "postal_code" => $input["postalCode"],
                "tax_number" => $input["taxNumber"],
                "tax_post" => $input["taxPost"],
                "discount" => $input["discount"],
                "occupation" => $input["occupation"],
                "note" => $input["note"],
                "note2" => $input["note2"]
        ];
       try{
        Clients::create($data);
        return json_encode([
            'error'=>false,
            'message'=>'Client created successfully.'
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
        $client_id = $input['client_id'];
        $data = [
                "name" => $input["name"],
                "mobile" => $input["mobile"],
                "telephone" => $input["telephone"],
                "address" => $input["address"],
                "city" => $input["city"],
                "region" => $input["region"],
                "postal_code" => $input["postalCode"],
                "tax_number" => $input["taxNumber"],
                "tax_post" => $input["taxPost"],
                "discount" => $input["discount"],
                "occupation" => $input["occupation"],
                "note" => $input["note"],
                "note2" => $input["note2"]
        ];
       try{
        Clients::where('client_id',$client_id)->update($data);
        return json_encode([
            'error'=>false,
            'message'=>'Client updated successfully.'
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
            $clients = Clients::get()->toArray();
        
            return json_encode([
                'error'=>false,
                'message'=>'client list',
                'clients'=> $clients
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