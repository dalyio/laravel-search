<?php

namespace Dalyio\Challenge\Traits\View\Component;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

trait Widgetable
{
    /**
     * @var string
     */
    private $label;
    
    /**
     * @var string
     */
    private $sublabel;
    
    /**
     * @var string
     */
    private $view;
    
    /**
     * @var int
     */
    private $priority = 100;
    
    /**
     * @var string
     */
    private $width = '50%';
    
    /**
     * @var string
     */
    private $color;
    
    /**
     * @var string
     */
    private $service;
    
    /**
     * @var string
     */
    private $method;
    
    /**
     * @var array
     */
    private $params = [];
    
    /**
     * @var int
     */
    private $resultsLimit = 10;
    
    /**
     * @return string
     */
    public function namespace()
    {
        return $this->namespace;
    }
    
    /**
     * @param string $namespace
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Chart
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function label()
    {
        return $this->label;
    }
    
    /**
     * @param string $label
     * @return mixed|Widgetable
     */
    public function setLabel($label)
    {
        $this->label = $label;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function sublabel()
    {
        return $this->sublabel;
    }
    
    /**
     * @param string $sublabel
     * @return mixed|Widgetable
     */
    public function setSublabel($sublabel)
    {
        $this->sublabel = $sublabel;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function view()
    {
        return $this->view;
    }
    
    /**
     * @param string $view
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Grid
     */
    public function setView($view)
    {
        $this->view = $view;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function priority()
    {
        return $this->priority;
    }
    
    /**
     * @param int $priority
     * @return mixed|Widgetable
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function width()
    {
        return $this->width;
    }
    
    /**
     * @param string $width
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Box
     */
    public function setWidth($width)
    {
        $this->width = $width;
        
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
     * @return \Dalyio\Challenge\View\Components\Dashboard\Widget\Chart
     */
    public function setColor($color)
    {
        $this->color = $color;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function service()
    {
        return $this->service;
    }
    
    /**
     * @param string $className
     * @return mixed|Widgetable
     */
    public function setService($className)
    {
        $this->service = App::make($className);
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function method()
    {
        return $this->method;
    }
    
    /**
     * @param string $method
     * @return mixed|Widgetable
     */
    public function setMethod($method)
    {
        $this->method = $method;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function params()
    {
        return $this->params;
    }
    
    /**
     * @param array $params
     * @return mixed|Widgetable
     */
    public function setParams($params)
    {
        $this->params = $params;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function resultsLimit()
    {
        return $this->resultsLimit;
    }
    
    /**
     * @param int $limit
     * @return mixed|Widgetable
     */
    public function setLimit($resultsLimit)
    {
        $this->resultsLimit = $resultsLimit;
        
        return $this;
    }
    
    /**
     * @param array $config
     * @return void
     */
    public function hydrateInfo($config)
    {
        if (Arr::has($config, 'label')) $this->setLabel(Arr::get($config, 'label'));
        if (Arr::has($config, 'sublabel')) $this->setSublabel(Arr::get($config, 'sublabel'));
        if (Arr::has($config, 'priority')) $this->setPriority(Arr::get($config, 'priority'));
    }
    
    /**
     * @param array $config
     * @return void
     */
    public function hydrateStyles($config)
    {
        if (Arr::has($config, 'style.width')) $this->setWidth(Arr::get($config, 'style.width'));
    }
    
    /**
     * @param array $config
     * @return void
     */
    public function hydrateServices($config)
    {
        if (Arr::has($config, 'data.service')) $this->setService(Arr::get($config, 'data.service'));
        if (Arr::has($config, 'data.method')) $this->setMethod(Arr::get($config, 'data.method'));
        if (Arr::has($config, 'data.params')) $this->setParams(Arr::get($config, 'data.params'));
    }
}
