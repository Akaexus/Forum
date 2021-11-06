<?php

class Board extends Controller {
    public $breadcrumb = [];
    public function manage()
    {
        $forums = Forum::loadAll();
        Output::i()->add(Template::i()->renderTemplate('board', [
            'forums' => $forums,
            'error' => 'Nazwa konta lub hasło nieprawidłowe'
        ]));
    }
    public function execute()
    {
        Output::i()->title = 'Forum';
        Output::i()->showHeader = true;
        Output::i()->showFooter = true;
        Output::i()->showBreadcrumb = true;
    }
}
