<?php

namespace Dalyio\Challenge\View\Components\Menu;

use Illuminate\Support\Facades\Request;

class Item
{
    /**
     * @var string
     */
    private $label;
    
    /**
     * @var int
     */
    private $priority;
    
    /**
     * @var string
     */
    private $icon;
    
    /**
     * @var string
     */
    private $url;
    
    /**
     * @var array
     */
    private $submenu;
    
    /**
     * @var array
     */
    private $acl;
    
    /**
     * @var boolean
     */
    private $isOpen;
    
    /**
     * @param array $config
     * @return void
     */
    public function __construct($config = null) 
    {
        if ($config) $this->hydrate($config);
    }
    
    /**
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.menu.item')->with([
            
        ]);
    }
    
    /**
     * @param array $config
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function hydrate($config)
    {
        if (isset($config['label'])) $this->setLabel($config['label']);
        if (isset($config['priority'])) $this->setPriority($config['priority']);
        if (isset($config['icon'])) $this->setIcon($config['icon']);
        if (isset($config['url'])) $this->setUrl($config['url']);
        if (isset($config['submenu'])) $this->setSubmenu($config['submenu']);
        if (isset($config['acl'])) $this->setAcl($config['acl']);
        
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
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function setLabel($label)
    {
        $this->label = $label;
        
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
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        
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
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function url()
    {
        return $this->url;
    }
    
    /**
     * @param string $url
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function setUrl($url)
    {
        $this->url = $url;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function submenu()
    {
        return $this->submenu;
    }
    
    /**
     * @param array $submenu
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function setSubmenu($submenu)
    {
        $this->submenu = collect(array_map(function($submenuItem) {
            return new self($submenuItem);
        }, $submenu));
        
        return $this;
    }
    
    /**
     * @return string|array
     */
    public function acl($part = null)
    {
        if (!$part) return $this->acl;
        return isset($this->acl[$part]) ? $this->acl[$part] : null;
    }
    
    /**
     * @param array $acl
     * @return \Dalyio\Challenge\View\Component\Menu\Item
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
        
        return $this;
    }
    
    /**
     * @return boolean
     */
    public function isOpen()
    {
        if ($this->url === '/'.Request::path()) {
            $this->isOpen = true;
        }
        
        if ($this->submenu) {
            $this->submenu->map(function($submenu) {
                if ($submenu->isOpen()) {
                    $this->isOpen = true;
                }
            });
        }
        
        return $this->isOpen;
    }
}
