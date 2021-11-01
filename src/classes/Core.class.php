<?php

class Core extends Singleton
{
    public function __construct() {
        session_start();
    }
    public function run() {
        $this->dispatcher();
        Output::i()->cssFiles[] = '/assets/css/main.css';
        Output::i()->jsFiles[] = 'https://kit.fontawesome.com/5efe299fc2.js';
        Output::i()->render();
    }

    public function dispatcher() {
        $controllerName = Request::i()->controller;
        $do = Request::i()->do ?? 'manage';
        $controller = new $controllerName();
        if ($do[0] == '_' || !method_exists($controller, $do)) {
            $do = 'manage';
        }
        $controller->$do();
    }
}