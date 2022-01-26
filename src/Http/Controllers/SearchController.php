<?php

namespace Dalyio\Search\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    /**
     * @var \Dalyio\Search\Services\SearchService
     */
    protected $searchService;
    
    /**
     * @return void
     */
    public function __construct() {
        $this->searchService = App::make(\Dalyio\Search\Services\SearchService::class);
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {
            return response()->json([
                'success' => true,
                'search_term' => $request->input('search_term'),
                'results' => $this->searchService->search($request->input('search_term'), $request->input('search_namespace'))
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'search_term' => $request['search_term'],
                'message' => $ex->getMessage()
            ]);
        }
    }
}
