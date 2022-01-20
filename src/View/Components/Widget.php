<?php

namespace Dalyio\Challenge\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Widget extends Component
{
    /**
     * string
     */
    private $namespace;
    
    /**
     * array
     */
    private $layout;
    
    /**
     * Dalyio\Challenge\View\Components\Widget\Box[]
     */
    private $widgetBoxes;
    
    /**
     * Dalyio\Challenge\View\Components\Widget\Chart[]
     */
    private $widgetCharts;
    
    /**
     * Dalyio\Challenge\View\Components\Widget\Grid[]
     */
    private $widgetGrids;
    
    /**
     * @param string $timeframe
     * @return void
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
        $this->layout = config('widget.'.$namespace.'.layout', []);
        
        $this->buildWidgetBoxes();
        $this->buildWidgetCharts();
        $this->buildWidgetGrids();
    }
    
    /**
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.widget')->with([
            'layouts' => $this->layout,
            'widgetBoxes' => $this->widgetBoxes(),
            'widgetCharts' => $this->widgetCharts(),
            'widgetGrids' => $this->widgetGrids()
        ]);
    }
    
    private function layout()
    {
        return $this->layout;
    }
    
    /**
     * Dalyio\Challenge\View\Components\Widget\Box[]
     */
    private function widgetBoxes()
    {
        return $this->widgetBoxes;
    }
    
    /**
     * Dalyio\Challenge\View\Components\Widget\Chart[]
     */
    private function widgetCharts()
    {
        return $this->widgetCharts;
    }
    
    /**
     * Dalyio\Challenge\View\Components\Widget\Grid[]
     */
    private function widgetGrids()
    {
        return $this->widgetGrids;
    }
    
    /**
     * @return void
     */
    private function buildWidgetBoxes()
    {
        $this->widgetBoxes = new \Illuminate\Support\Collection();
        foreach (config('widget.'.$this->namespace.'.box', []) as $namespace => $boxConfig) {
            $this->widgetBoxes->push(new \Dalyio\Challenge\View\Components\Widget\Box($namespace, $boxConfig));
        }
        
        return $this->widgetBoxes->sortBy(function($widgetBox) {
            return $widgetBox->priority();
        });
    }
    
    /**
     * @return void
     */
    private function buildWidgetCharts()
    {
        $this->widgetCharts = new \Illuminate\Support\Collection();
        foreach (config('widget.'.$this->namespace.'.chart', []) as $namespace => $chartConfig) {
            $this->widgetCharts->push(new \Dalyio\Challenge\View\Components\Widget\Chart($namespace, $chartConfig));
        }
        
        return $this->widgetCharts->sortBy(function($widgetChart) {
            return $widgetChart->priority();
        });
    }
    
    /**
     * @return void
     */
    private function buildWidgetGrids()
    {
        $this->widgetGrids = new \Illuminate\Support\Collection();
        foreach (config('widget.'.$this->namespace.'.grid', []) as $namespace => $gridConfig) {
            $this->widgetGrids->push(new \Dalyio\Challenge\View\Components\Widget\Grid($namespace, $gridConfig));
        }
        
        $this->widgetGrids->sortBy(function($widgetGrid) {
            return $widgetGrid->priority();
        });
    }
}
