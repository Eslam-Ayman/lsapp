<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // the next comment is wrong you can uncomment it and test it .... it will not return an object to check it 
        // $val = $this->validate($request, ['email'=>'required|email', 'password'=>'required']);
        
        // the defferance between two lines that you can use request helper or you can use request object 
        // $val = Validator::make($request->all(), ['email'=>'required|email', 'password'=>'required']);
        $val = Validator::make(request()->all(), ['email'=>'required|email', 'password'=>'required']);
        // return dd($val);
        
        if ($val->fails()) {
            return response(['***status'=>false, '***messages'=>$val->messages()], 422 /*, you can pass header here*/);
        }
        else{
            if (auth()->attempt(['email'=>request('email'), 'password'=>$request->password])) {
                auth()->user()->api_token = str_random(60);
                auth()->user()->save();
                return response(['status_lol'=>'200',
                                 'user_data'=>auth()->user(),
                                  "user_token"=>auth()->user()->api_token], 200 , ['Header'=>'Value']);
            }
            else{
                return response(['***status'=>false, '***messages'=>'your cardientials is wrong'], 400);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
