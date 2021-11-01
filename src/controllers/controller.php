<?php



abstract class Controller
{
    public static $controllers = [
        'studentClasses' => [
            'permissions'=> ['t']
        ],
        // 'dashboard'=> [
        //     'permissions'=> ['u']
        // ],
        'login'=> [
            'permissions'=> ['g']
        ],
        'studentStats' => [
            'permissions'=> ['u']
        ],
        'subjectInfo' => [
            'permissions'=> ['t']
        ],
        'timetable' => [
            'permissions'=> ['u']
        ],
        'account' => [
            'permissions'=> ['u']
        ],
        'logout' => [
            'permissions'=> ['u']
        ],
    ];

    public static function getAvailableControllers($user = null)
    {
        if (!$user) {
            if (User::loggedIn()) {
                $user = User::loggedIn();
            }
        }
        $permissionMap = $user ? User::getPermissionMap($user) : ['g'];
        $controllers = [];
        foreach (static::$controllers as $controllerName => $controller) {
            foreach ($controller['permissions'] as $perm) {
                if (in_array($perm, $permissionMap)) {
                    $controllers[$controllerName] = $controller;
                    break;
                }
            }
        }
        return $controllers;
    }

    abstract public function execute();

    public function __construct()
    {
        $this->execute();
        if (array_key_exists('do', $_GET)) {
            $req = $_GET['do'];
            if (strlen($req) === 0 || $req[0] === '_') {
                $this->execute();
            } else {
                if (method_exists($this, $req)) {
                    $this->$req();
                } else {
                    $this->manage();
                }
            }
        } else {
            $this->manage();
        }
    }
}