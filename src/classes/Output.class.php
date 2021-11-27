<?php

class Output extends Singleton
{
    private $_output;
    public $title;
    public $cssFiles = [];
    public $jsFiles = [];
    public $showHeader = true;
    public $showFooter = true;
    public $showBreadcrumb = true;
    protected $templatingEngine;
    public $breadcrumb = [[
        'name'=> 'Forum',
        'url'=> '/'
    ]];

    public function addBreadcrumb($array)
    {
        if ($array) {
            $this->breadcrumb = array_merge($this->breadcrumb, $array);
        }
    }


    public function redirect($url, $internal = true)
    {
        $baseUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($internal) {
            $url = $baseUrl.$url;
        }
        header('Location: '.$url, 302);
    }

    public function add($string)
    {
        $this->_output .= $string;
    }

    public function error($errorCode = null, $message = null, $description = null)
    {
        $this->title = 'Błąd ' . $errorCode;
        $this->add(
            Template::i()->renderTemplate('error', [
                'errorCode'=> $errorCode,
                'message'=> $message,
                'description'=> $description
            ], 'core')
        );
    }

    public function render($toString = false)
    {
        $output = Template::i('core')->renderTemplate(
            'core',
            [
                'title'=> $this->title,
                'output'=> $this->_output,
                'jsFiles'=> $this->jsFiles,
                'cssFiles'=> $this->cssFiles,
                'breadcrumb'=> $this->showBreadcrumb ? $this->breadcrumb : null,
                'user'=> User::loggedIn(),
                'header'=> $this->showHeader ? Template::i('core')->renderTemplate('header', []) : null,
                'footer'=> $this->showFooter ? Template::i('core')->renderTemplate('footer', [])  : null,
            ]
        );
        if ($toString) {
            return $output;
        } else {
            echo $output;
        }
        return true;
    }

    public static function truncate($text, $words = 25) {
        return implode(' ', array_slice(explode(' ', $text), 0, $words)) . '...';
    }
}
