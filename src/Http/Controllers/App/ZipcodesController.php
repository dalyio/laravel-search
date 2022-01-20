<?php

namespace Dalyio\Challenge\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ZipcodesController extends Controller
{
    /**
     * @var \Dalyio\Challenge\Services\CalcDistance
     */
    private $calcDistance;
    
    /**
     * @var \Dalyio\Challenge\Services\ZipcodeSearch
     */
    private $zipcodeSearch;
    
    /**
     * @return void
     */
    public function __construct(
        \Dalyio\Challenge\Services\CalcDistance $calcDistance,
        \Dalyio\Challenge\Services\ZipcodeSearch $zipcodeSearch
    ) {
        $this->calcDistance = $calcDistance;
        $this->zipcodeSearch = $zipcodeSearch;
    }
    
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function solution()
    {
        return view('app.zipcodes.solution');
    }
    
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function docs()
    {
        return view('app.zipcodes.docs');
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        try {
            timer('start');
            return response()->json([
                'success' => true,
                'results' => $this->zipcodeSearch->search($request->input('search')),
                'timer' => timer('result'),
            ]);
        } catch (HttpException $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function distance(Request $request)
    {
        try {
            timer('start');
            return response()->json([
                'success' => true,
                'data' => $this->calcDistance->byZipcodes($request->input('zipcodes')),
                'timer' => timer('result'),
            ]);
        } catch (HttpException $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }
}
