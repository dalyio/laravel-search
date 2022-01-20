<?php

namespace Dalyio\Challenge\View\Components\Widget;

use Dalyio\Challenge\Traits\View\Component\Widgetable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Box extends Component
{
    use Widgetable;
    
    /**
     * @var array
     */
    private $data = [];
    
    /**
     * @param array $config
     * @param string $namespace
     * @return void
     */
    public function __construct($namespace, $config) 
    {
        $this->setNamespace($namespace);
        $this->hydrate($config);
        
        $this->calculateData();
    }
    
    /**
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.widget.box')->with([
            'label' => $this->label(),
            'color' => $this->color(),
            'icon' => $this->icon(),
            'width' => $this->width(),
            'data' => $this->pullData(),
        ]);
    }
    
    /**
     * @param array $config
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Box
     */
    public function hydrate($config)
    {
        $this->hydrateInfo($config);
        $this->hydrateStyles($config);
        $this->hydrateServices($config);
        
        if (Arr::has($config, 'style.color')) $this->setColor(Arr::get($config, 'style.color'));
        if (Arr::has($config, 'style.icon')) $this->setIcon(Arr::get($config, 'style.icon'));
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function color()
    {
        return $this->color;
    }
    
    /**
     * @param string $color
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Box
     */
    public function setColor($color)
    {
        $this->color = $color;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function icon()
    {
        return $this->icon;
    }
    
    /**
     * @param string $icon
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Box
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        
        return $this;
    }
    
    public function pullData($key = null)
    {
        return ($key) ? Arr::pull($this->data, $key, 0) : $this->data;
    }
    
    public function calculateData()
    {
        $this->data = call_user_func_array([$this->service, $this->method], array_merge([], $this->params));
    }
}
