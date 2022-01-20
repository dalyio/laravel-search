<?php

namespace Dalyio\Challenge\View\Components\Widget;

use Dalyio\Challenge\Traits\View\Component\Widgetable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Chart extends Component
{
    use Widgetable;
    
    /**
     * @var array
     */
    private $data = [
        'categories' => [],
        'data' => [],
    ];
    
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
        return view($this->view())->with([
            'label' => $this->label(),
            'sublabel' => $this->sublabel(),
            'color' => $this->color(),
            'width' => $this->width(),
            'categories' => $this->pullData('categories'),
            'data' => $this->pullData('data'),
        ]);
    }
    
    /**
     * @param array $config
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Chart
     */
    public function hydrate($config)
    {
        $this->hydrateInfo($config);
        $this->hydrateStyles($config);
        $this->hydrateServices($config);
        
        if (Arr::has($config, 'view')) $this->setView(Arr::get($config, 'view'));
        if (Arr::has($config, 'style.color')) $this->setColor(Arr::get($config, 'style.color'));
        
        return $this;
    }
    
    public function pullData($key = null)
    {
        return ($key) ? Arr::pull($this->data, $key, 0) : $this->data;
    }
    
    public function calculateData()
    {
        $data = call_user_func_array([$this->service, $this->method], $this->params);
        //$this->data['categories'] = $data->pluck('x');
        
        $this->data['data'] = $data->toArray();
    }
}
