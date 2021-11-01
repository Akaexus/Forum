<?php

function loadClassOrFail($path) {
    if (file_exists($path)) {
        require_once($path);
        return true;
    }
    return false;
}

spl_autoload_register(function($class) {
    $directories = [
        'models/',
        'controllers/',
        'classes/'
    ];

    foreach($directories as $directory)
    {
        $paths = [
            "{$class}.php",
            "{$class}.class.php",
            strtolower($class).".php",
            strtolower($class).".class.php",
        ];
        foreach ($paths as $path) {
            if (loadClassOrFail(ROOT_PATH.$directory.$path)) {
                break;
            }
        }
    }
});