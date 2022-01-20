<?php

namespace Dalyio\Challenge\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppController extends Controller
{
    /**
     * @return void
     */
    public function __construct() {
        
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('app.index');
    }
}
