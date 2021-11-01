<?php

class Template
{
    public $controller;
    public $templateName;
    public function __construct($controller, $templateName)
    {
        $this->controller = $controller;
        $this->templateName = $templateName;
    }

    public function render($params = [])
    {
        extract($params);
        ob_start();
        include ROOT_PATH . "templates/{$this->controller}/{$this->templateName}.phtml";
        return ob_get_clean();
    }
}