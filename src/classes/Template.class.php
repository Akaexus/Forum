<?php

class Template
{
    public $controller;
    public $templateName;

    public static function i($controller = null) {
        $controller = $controller ?? Request::i()->controller;
        return new Template($controller);
    }

    public function __construct($controller)
    {
        $this->templatingEngine = new Latte\Engine();
        $this->controller = $controller;
    }

    public function renderTemplate($template, $params = []) {
        return $this->templatingEngine->renderToString(ROOT_PATH."templates/{$this->controller}/{$template}.phtml", $params);
    }
}