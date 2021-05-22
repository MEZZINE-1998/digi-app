<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request){

    	$var = [0,1,2];

    	$request->session()->put(['key2', $var]);
    	// $request->session()->forget('ings_id');
    	echo "hello world ".$request->session()->get('key');

    	dd($request->session()->all());
    }
}
