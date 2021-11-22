<?php

abstract class Controller
{
    public static $defaultController = 'board';
    public $breadcrumb = [];
    public static $controllers = [
        'board'=> [
            'loggedIn'=> true,
        ],
        'trophies'=> [
            'loggedIn'=> true,
        ],
        'statuses'=> [
            'loggedIn'=> true,
        ],
        'announcements'=> [
            'loggedIn'=> true,
        ],
        'register'=> [
            'loggedIn'=> false,
        ],
        'forums'=> [
            'loggedIn'=> true,
        ],
        'posts'=> [
            'loggedIn'=> true,
        ],
        'topics'=> [
            'loggedIn'=> true,
        ],
        'login'=> [
            'loggedIn'=> false,
        ],
        'members' => [
            'loggedIn'=> true,
        ],
        'logout' => [
            'loggedIn'=> true,
        ],
        'follows' => [
            'loggedIn'=> true,
        ]
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
        $this->execute();
        Output::i()->addBreadcrumb($this->breadcrumb);
    }
}