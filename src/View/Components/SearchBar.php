<?php

namespace Dalyio\Search\View\Components;

use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class SearchBar extends Component
{
    /**
     * string
     */
    protected $namespace;
    
    /**
     * string|int
     */
    protected $debounce;
    
    /**
     * string|int
     */
    protected $limit;
    
    /**
     * string|int
     */
    protected $width;
    
    /**
     * boolean
     */
    protected $useCss;
    
    /**
     * @var \Dalyio\Search\Services\SearchService
     */
    protected $searchService;
    
    /**
     * @return void
     */
    public function __construct($namespace = 'default', $debounce = 500, $limit = null, $width = null, $useCss = true)
    {
        $this->searchService = App::make(\Dalyio\Search\Services\SearchService::class);
        
        $this->namespace = $namespace;
        $this->debounce = $debounce;
        $this->limit = ($limit) ? $limit : config('search.limit', 10);
        $this->width = ($width) ? $width : config('search.width', '400px');
        $this->useCss = filter_var($useCss, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.search-bar')->with([
            'namespace' => $this->namespace,
            'debounce' => $this->debounce,
            'width' => $this->width,
            'useCss' => $this->useCss
        ]);
    }
}
