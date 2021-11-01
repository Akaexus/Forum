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
        $this->breadcrumb = array_merge($this->breadcrumb, $array);
    }

    public function __construct()
    {
        $this->templatingEngine = new Latte\Engine();
        if (defined('DEV_MODE') && DEV_MODE) {
            $this->templatingEngine->setAutoRefresh(false);
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

    public function error($errorCode = null, $message = null)
    {
        $this->add(
            $this->renderTemplate(
                'core',
                'error',
                [
                    'errorCode'=> $errorCode,
                    'message'=> $message,
                ]
            )
        );
        echo $this->render();
        die();
    }

    public function render($toString = false)
    {
        $output = $this->renderTemplate(
            'core',
            'core',
            [
                'title'=> $this->title,
                'output'=> $this->_output,
                'jsFiles'=> $this->jsFiles,
                'cssFiles'=> $this->cssFiles,
                'breadcrumb'=> $this->showBreadcrumb ? $this->breadcrumb : null,
                'user'=> User::loggedIn()
            ]
        );
        if ($toString) {
            return $output;
        } else {
            echo $output;
        }
    }

    public function renderTemplate($controller, $template, $params = [])
    {
        $header = $this->showHeader ? $this->templatingEngine->renderToString(ROOT_PATH."templates/core/header.phtml", []) : null;
        $footer = $this->showFooter ? $this->templatingEngine->renderToString(ROOT_PATH."templates/core/footer.phtml", []) : null;
        $params['controller'] = Request::i()->controller;
        $params['header'] = $header;
        $params['footer'] = $footer;
        $output = $this->templatingEngine->renderToString(ROOT_PATH."templates/{$controller}/{$template}.phtml", $params);
        return $output;
    }
}
