<?php

class Core extends Singleton
{
    public function __construct() {
        session_start();
    }
    public function run() {
        $this->dispatcher();
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