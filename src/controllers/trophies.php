<?php

class Trophies extends Controller {
    public $trophy = null;
    public $breadcrumb;

    public function manage()
    {
        Output::i()->redirect('?');
    }

    public function delete() {
        if ($this->trophy && User::loggedIn()->isAdmin()) {
            $this->trophy->delete();
            Output::i()->redirect($this->trophy->given()->url());
        }
    }

    public function add() {
        $member = null;
        if (isset(Request::i()->member_id) && ctype_digit(Request::i()->member_id)) {
            $member = User::load(Request::i()->member_id);
        }

        if ($member && User::loggedIn()->isAdmin()) {
            $form = Trophy::form();
            if ($form->isSuccess()) {

                $trophy = new Trophy($form->getValues());
                $trophy->giver_id = User::loggedIn()->member_id;
                $trophy->given_id = $member->member_id;
                $trophy->_new = true;
                $trophy->save();

                Output::i()->redirect($member->url());
            } else {
                Output::i()->add(Template::i()->renderTemplate('add', [
                    'member' => $member,
                    'form' => $form,
                ]));
            }
        } else {
            Output::i()->redirect('?');
        }
    }


    public function edit() {
        if ($this->trophy && User::loggedIn()->isAdmin()) {
            $form = Trophy::form($this->trophy);
            if ($form->isSuccess()) {
                $this->trophy->apply($form->getValues());
                Output::i()->redirect($this->trophy->given()->url());
            } else {
                Output::i()->add(Template::i()->renderTemplate('edit', [
                    'trophy' => $this->trophy,
                    'form' => $form,
                ]));
            }
        } else {
            Output::i()->redirect('?');
        }
    }



    public function execute()
    {
        if (isset(Request::i()->trophy_id) && ctype_digit(Request::i()->trophy_id)) {
            $this->trophy = Trophy::load(Request::i()->trophy_id);
        }
        Output::i()->title = 'Trofea';
        $this->breadcrumb = [[
            'name' => 'Trofea',
            'url' => '?controller=trophies'
        ]];
    }
}
