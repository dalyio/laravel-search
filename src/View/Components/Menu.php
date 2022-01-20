<?php

namespace Dalyio\Challenge\View\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Menu extends Component
{
    /*
     * @var \Dalyio\Challenge\View\Components\Menu\Item[]
     */
    private $menuItems;
    
    /*
     * @var string
     */
    private $namespace;
    
    /**
     * @param string $namespace
     * @return void
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
        $this->menuItems = new Collection();
        
        $this->buildMenuItems();
    }
    
    /**
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.menu')->with([
            'menuItems' => $this->menuItems()
        ]);
    }
    
    /**
     * @return \App\View\Components\Menu\Item[]
     */
    private function menuItems()
    {
        return $this->menuItems->sortBy(function($menuItem) {
            return $menuItem->priority();
        });
    }
    
    /**
     * @param array $config
     * @return \App\View\Components\Menu
     */
    private function addMenuItems($config)
    {
        foreach ($config as $itemConfig) {
            $this->addMenuItem($itemConfig);
        }
        
        return $this;
    }
    
    /**
     * @param array $config
     * @return \App\View\Components\Menu
     */
    private function addMenuItem($config)
    {
        $this->menuItems->push(new \Dalyio\Challenge\View\Components\Menu\Item($config));
        
        return $this;
    }
    
    /**
     * @return void
     */
    private function buildMenuItems()
    {
        $this->addMenuItems(($this->namespace) ? config('menu.'.$this->namespace, []) : []);
    }
}
