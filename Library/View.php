<?php

namespace MyApp\Library;

class View
{
    protected $path, $controllerName, $action;

    public $data;

    public function __construct($path, $controller, $action)
    {
        $this->path = $path;
        $this->controllerName = $controller;
        $this->action = $action;

    }

    public function setData($data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
        
    }


    public function render()
    {
        $filename = $this->path.DIRECTORY_SEPARATOR.$this->controllerName.DIRECTORY_SEPARATOR.$this->action.DIRECTORY_SEPARATOR.$this->action.".xyz";    //c:/......../faramwwork-schulung1023/views/stundet/index/index.phtml 

        if(isset($this->data)) {
            foreach ($this->data as $key => $value) {
                $$key = $value;
                
            }
        }
        
        include $filename;//index.phtml
    }


}