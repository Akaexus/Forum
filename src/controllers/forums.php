<?php

class Forums extends Controller {
    public $forum = null;
    public $breadcrumb;

    public function manage()
    {
        Output::i()->add(Template::i()->renderTemplate('list', [
            'forum' => $this->forum,
            'topics' => $this->forum->getTopics(),
        ]));
    }

    public function edit() {
        if (User::loggedIn()->isAdmin()) {
            Output::i()->title = 'Edytuj ' . $this->forum->name;
            $form = Forum::form($this->forum);
            if ($form->isSuccess()) {
                $this->forum->apply($form->getValues());
                Output::i()->redirect($this->forum->url());
            } else {
                Output::i()->add(Template::i()->renderTemplate('edit', [
                    'forum' => $this->forum,
                    'form' => $form
                ]));
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
        $this->breadcrumb = [[
            'name'=> $this->forum->name,
            'url'=> $this->forum->url()
        ]];
    }
}
