<?php

class Logout extends Controller {
    public static $breadcrumb = [
        [
            'name'=> 'Zaloguj',
            'url'=> '?controller=login'
        ]
    ];
    public function manage()
    {
        if (User::loggedIn()) {
            User::logout();
            Output::i()->redirect('?');
        } else {
            Output::i()->redirect('?controller=login');
        }
    }
    public function execute()
    {
        Output::i()->title = 'Zaloguj';
        Output::i()->showHeader = true;
        Output::i()->showFooter = true;
        Output::i()->showBreadcrumb = true;
    }
}
