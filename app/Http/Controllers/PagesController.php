<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index ()
    {
        $title = "Hello, world!";
        return view('pages.index' , compact('title'));
        // return view('pages.index')->with('the name that will be used in blade file' , $title);
    }

    public function about()
    {
    	return view('pages.about');
    }

    public function services()
    {
        $data = array(
                      'title' => 'Services',
                      'list' => ['service 1' , 'service 2' , 'service 3']
                      );
    	return view('pages.services')->with($data);
    }

}
