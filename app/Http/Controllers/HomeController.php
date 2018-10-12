<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CurrentUserID = auth()->user()->id;
        $AllUserData = User::find($CurrentUserID);
        return view('dashboard')->with('posts', $AllUserData->pos);
    }
}
