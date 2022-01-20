<?php

namespace Dalyio\Challenge\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ChallengeServiceProvider extends ServiceProvider
{    
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfig([
            realpath(__DIR__.'/../../config/app.php') => 'app',
            realpath(__DIR__.'/../../config/challenge.php') => 'challenge',
            realpath(__DIR__.'/../../config/git.php') => 'git',
            realpath(__DIR__.'/../../config/menu.php') => 'menu',
            realpath(__DIR__.'/../../config/widget.php') => 'widget',
        ]);
        
        $this->publishes([
            realpath(__DIR__.'/../../resources/assets') => resource_path('/assets'),
            realpath(__DIR__.'/../../storage') => storage_path(),
            realpath(__DIR__.'/../../webpack.mix.js') => base_path('/webpack.mix.js'),
            realpath(__DIR__.'/../../package.json') => base_path('/package.json'),
        ], 'install');
        
        $this->registerHelpers();
        //$this->registerPolicies();
    }

    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->configureCommands();
        }
        
        $this->configureRoutes();
        $this->configureViews();
    }
    
    protected function configureCommands()
    {
        $this->commands([
            \Dalyio\Challenge\Console\Commands\ChallengeInstall::class,
            \Dalyio\Challenge\Console\Commands\ChallengeNumberchain::class,
            \Dalyio\Challenge\Console\Commands\ChallengeZipcodes::class,
        ]);
    }
    
    protected function configureRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace('Dalyio\Challenge\Http\Controllers\Api')
            ->group(realpath(__DIR__.'/../../routes/api.php'));

        Route::middleware('web')
            ->namespace('Dalyio\Challenge\Http\Controllers')
            ->group(realpath(__DIR__.'/../../routes/app.php'));
    }
    
    protected function configureViews()
    {
        View::getFinder()->addLocation(realpath(__DIR__.'/../../resources/views'));
        
        Blade::component('menu', \Dalyio\Challenge\View\Components\Menu::class);
        Blade::component('widget', \Dalyio\Challenge\View\Components\Widget::class);
        Blade::component('widget.box', \Dalyio\Challenge\View\Components\Widget\Box::class);
        Blade::component('widget.chart', \Dalyio\Challenge\View\Components\Widget\Chart::class);
        Blade::component('widget.grid', \Dalyio\Challenge\View\Components\Widget\Grid::class);
    }
    
    protected function registerHelpers()
    {
        foreach (glob(__DIR__.'/../../resources/helpers/*.php') as $filename) {
            require_once(realpath($filename));
        }
    }
    
    protected function registerPolicies()
    {
        //Gate::define('chellenge.access', [\Dalyio\Challenge\Policies\AccessPolicy::class, 'index']);
    }
    
    /**
     * @param array $configs
     * @return void
     */
    protected function mergeConfig($configs)
    {
        if (!$this->app->configurationIsCached()) {
            foreach ($configs as $path => $namespace) {
                $this->app['config']->set($namespace, array_replace_recursive(
                   $this->app['config']->get($namespace, []), require $path
                ));
            }
        }
    }
}
