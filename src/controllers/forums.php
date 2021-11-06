<?php

class Forums extends Controller {
    public $forum = null;
    public static $breadcrumb = [
        [
            'name'=> 'Board',
            'url'=> '?controller=login'
        ]
    ];
    public function manage()
    {
        $forums = Forum::loadAll();
        if (Request::i()->forum_id) {
            Output::i()->add(Request::i()->forum_id);
        }
//        Output::i()->add(Template::i()->renderTemplate('board', [
//            'forums' => $forums,
//            'error' => 'Nazwa konta lub hasło nieprawidłowe'
//        ]));
        Output::i()->add('forums');
    }

    public function edit() {
        if (User::loggedIn()->isAdmin()) {
            Output::i()->title = 'Edytuj ' . $this->forum->name;
            $form = Forum::form($this->forum);
            if ($form->isSuccess()) {
                $this->forum->apply($form->getValues());
                Output::i()->redirect($this->forum->url());
            } else {
                Output::i()->add(Forum::form($this->forum));
            }
        }
    }

    public function execute()
    {
        if (isset(Request::i()->forum_id) && ctype_digit(Request::i()->forum_id)) {
            $this->forum = Forum::load(Request::i()->forum_id);
        }

        if ($this->forum == null) {
            Output::i()->redirect('?');
        }
        Output::i()->title = $this->forum->name;
    }
}
