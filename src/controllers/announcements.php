<?php

class Announcements extends Controller {
    public $breadcrumb;
    public $announcement = null;
    public function manage()
    {
        $announcements = Announcement::loadAll();
        Output::i()->add(Template::i()->renderTemplate('list', [
            'announcements' => $announcements,
        ]));
    }
    public function delete() {
        if (User::loggedIn()->isAdmin()) {
            if ($this->announcement) {
                $this->announcement->delete();
            }
            Output::i()->redirect('?controller=announcements');
        }
    }
    public function add() {
        if (User::loggedIn()->isAdmin()) {
            $form = Announcement::form();
            if ($form->isSuccess()) {
                $ann = new Announcement($form->getValues());
                $ann->author_id = User::loggedIn()->member_id;
                $ann->_new = true;
                $ann->save();
                Output::i()->redirect('?controller=announcements');
            } else {
                Output::i()->add(Template::i()->renderTemplate('add', [
                    'form' => $form,
                ]));
            }
        } else {
            Output::i()->redirect('?controller=announcements');
        }
    }

    public function edit() {
        if (User::loggedIn()->isAdmin() && $this->announcement) {
            $form = Announcement::form($this->announcement);
            if ($form->isSuccess()) {
                $this->announcement->apply($form->getValues());
                Output::i()->redirect('?controller=announcements');
            } else {
                Output::i()->add(Template::i()->renderTemplate('edit', [
                    'form' => $form,
                    'ann' => $this->announcement
                ]));
            }
        } else {
            Output::i()->redirect('?controller=announcements');
        }
    }



    public function execute()
    {
        if (isset(Request::i()->announcement_id) && ctype_digit(Request::i()->announcement_id)) {
            $this->announcement = Announcement::load(Request::i()->announcement_id);
        }
        Output::i()->title = 'Ogłoszenia';
        $this->breadcrumb = [[
            'name' => 'Ogłoszenia',
            'url' => '?controller=announcements'
        ]];
    }
}
