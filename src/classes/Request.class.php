<?php

class Request extends Singleton
{
    protected $__protectedProperties = [
        '__protectedProperties'
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
        $this->controller = Controller::_checkAvailableController($this->controller ?? null);
    }
}