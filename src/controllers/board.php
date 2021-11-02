<?php

class Board extends Controller {
    public static $breadcrumb = [
        [
            'name'=> 'Board',
            'url'=> '?controller=login'
        ]
    ];
    public function manage()
    {
        Output::i()->add('board');
    }
    public function execute()
    {
        Output::i()->title = 'Forum';
        Output::i()->showHeader = true;
        Output::i()->showFooter = true;
        Output::i()->showBreadcrumb = true;
    }
}
