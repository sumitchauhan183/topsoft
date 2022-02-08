<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Classes\Utils;

class InvoiceController extends Controller
{

    public function __construct(Request $request)
    {
        
    }

    
    /**
     * Show Admin Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    

    public function create(){
        return json_encode(["data"=>"Api working fine"]);
    }
}