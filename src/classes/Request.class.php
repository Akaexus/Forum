<?php

class Request extends Singleton
{
    protected $__data = [];
    protected $__protectedProperties = [
        '__data',
        '__protectedProperties',
        'controller',
    ];
    public function __construct()
    {
        $data = array_merge($_POST, $_GET);
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->__protectedProperties) && preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $key)) {
                $this->$key = trim(htmlspecialchars($value));
            } else {
                unset($data[$key]);
            }
        }

        $controllers = Controller::getAvailableControllers();
        if (array_key_exists('s', $data) && array_key_exists($data['s'], $controllers)) {
            $this->controller = $data['s'];
        } else {
            $this->controller = array_keys($controllers)[0];
        }
    }
}