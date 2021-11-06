<?php

abstract class Controller
{
    public static $defaultController = 'board';
    public static $breadcrumb = [];
    public static $controllers = [
        'board'=> [
            'loggedIn'=> true,
        ],
        'register'=> [
            'loggedIn'=> false,
        ],
        'forums'=> [
            'loggedIn'=> true,
        ],
        'login'=> [
            'loggedIn'=> false,
        ],
        'logout' => [
            'loggedIn'=> true
        ],
    ];

    public static function _checkAvailableController($controller) {
        $controller = $controller ?? static::$defaultController;
        if (!array_key_exists($controller, static::$controllers)) {
            $controller = static::$defaultController;
        }

        if (static::$controllers[$controller]['loggedIn'] && !User::loggedIn()) {
            $controller = 'login';
        }

        return $controller;
    }

    abstract public function execute();

    public function __construct()
    {
        Output::i()->addBreadcrumb(static::$breadcrumb);
        $this->execute();
    }
}