<?php

namespace Dalyio\Challenge\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class NumberchainController extends Controller
{
    /**
     * @var \Dalyio\Challenge\Services\SquareOfDigitsService
     */
    private $squareOfDigits;
    
    /**
     * @return void
     */
    public function __construct(
        \Dalyio\Challenge\Services\SquareOfDigits $squareOfDigits
    ) {
        $this->squareOfDigits = $squareOfDigits;
    }
    
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function solution()
    {
        return view('app.numberchain.solution');
    }
    
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function data()
    {
        return view('app.numberchain.data');
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function testNumberchain(Request $request)
    {
        try {
            timer('start');
            return response()->json([
                'success' => true,
                'numberchain' => $this->squareOfDigits->numberChain((int) $request->input('number')),
                'timer' => timer('result'),
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => __('error message here'),
            ]);
        }
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function testProblem(Request $request)
    {
        try {
            timer('start');
            return response()->json([
                'success' => true,
                'result' => $this->squareOfDigits->arrivesAt((int) $request->input('test_limit'), (int) $request->input('arrival_number')),
                'timer' => timer('result'),
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => __('error message here'),
            ]);
        }
    }
}
