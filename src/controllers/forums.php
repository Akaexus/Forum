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
        } else {
            Output::i()->redirect('?');
        }
    }

    public function add() {

        if (User::loggedIn()->isAdmin()) {
            Output::i()->title = 'Dodaj nowe forum';
            $form = Forum::form();
            if ($form->isSuccess()) {

                $forum = new Forum($form->getValues());
                $forum->_new = true;
                $forum->save();
                Output::i()->redirect($forum->url());
            } else {
                Output::i()->add(Template::i()->renderTemplate('add', [
                    'form' => $form
                ]));
            }
        } else {
            Output::i()->redirect('?');
        }
    }

    public function delete() {
        if (Topic::loadAll([['forum_id = ?', $this->forum->forum_id]], true) > 0) {
            $forums = Forum::loadAll([['forum_id != ?', $this->forum->forum_id]]);
            $form = new \Nette\Forms\Form();
            $forums_options = [];
            foreach ($forums as $forum) {
                $forums_options[$forum->forum_id] = $forum->name;
            }

            $form->addSelect('forum_id', 'Forum do przeniesienia:', $forums_options)
                ->setRequired('Uzupełnij forum do przeniesienia tematów!');
            $form->addSubmit('send', 'Przenieś');

            if ($form->isSuccess()) {
                DB::i()->query("CALL moveTopics({$this->forum->forum_id}, {$form->getValues()['forum_id']});");
                $this->forum->delete();
                Output::i()->redirect('?');
            } else {
                Output::i()->add(Template::i()->renderTemplate('deleteMove', [
                    'form' => $form,
                    'forum' => $this->forum,
                ]));
            }
        } else {
            $this->forum->delete();
            Output::i()->redirect('?');
        }
    }

    public function execute()
    {
        if (isset(Request::i()->do) && Request::i()->do == 'add') {
            Output::i()->title = 'Dodaj nowe forum';
            $this->breadcrumb = [[
                'name' => 'Dodaj nowe forum',
                'url' => '?controller=forums&do=add'
            ]];
        } else {
            if (isset(Request::i()->forum_id) && ctype_digit(Request::i()->forum_id)) {
                $this->forum = Forum::load(Request::i()->forum_id);
            }

            if ($this->forum == null) {
                Output::i()->redirect('?');
            }
            Output::i()->title = $this->forum->name;
            $this->breadcrumb = [[
                'name' => $this->forum->name,
                'url' => $this->forum->url()
            ]];
        }
    }
}
