<?php

namespace Dalyio\Search\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{    
    /**
     * @return void
     */
    public function register()
    {
        $this->publishes([
            realpath(__DIR__.'/../../config/search.php') => config_path('search.php'),
        ]);
    }

    /**
     * @return void
     */
    public function boot()
    {
        Route::namespace('Dalyio\Search\Http\Controllers')
            ->group(realpath(__DIR__.'/../../routes/search.php'));
        
        View::getFinder()
            ->addLocation(realpath(__DIR__.'/../../resources/views'));
        
        Blade::component('search-bar', \Dalyio\Search\View\Components\SearchBar::class);
    }
}
