<?php

class Statuses extends Controller {
    public $status = null;
    public $comment = null;
    public $breadcrumb;

    public function manage()
    {
        if ($this->status) {
            $statuses = [$this->status];
        } else {
            $statuses = Status::loadAll(null, false, 'created desc');
        }
        if (count($statuses) && $statuses[0]->commentForm()->isSuccess()) {
            $values = $statuses[0]->commentForm()->getValues();
            if (Status::load($values['status_id'])) {
                $values['author_id'] = User::loggedIn()->member_id;
                $comment = new StatusComment($values);
                $comment->_new = true;
                $comment->save();
                Output::i()->redirect($comment->status()->url());
            } else {
                Output::i()->redirect('?controller=statuses');
            }
        } else {
            Output::i()->add(Template::i()->renderTemplate('list', [
                'statuses' => $statuses,
            ]));
        }
    }

    public function delete() {
        if ($this->comment?->canEdit()) {
            $this->comment->delete();
            Output::i()->redirect($this->comment->status()->url());
        }
        if ($this->status?->canEdit()) {
            $this->status->delete();
            Output::i()->redirect('?controller=statuses');
        }
    }

    public function add() {
        $form = Status::form();
        if ($form->isSuccess()) {

            $status = new Status($form->getValues());
            $status->author_id = User::loggedIn()->member_id;
            $status->_new = true;
            $status->save();

            Output::i()->redirect($status->url());
        } else {
            Output::i()->add(Template::i()->renderTemplate('add', [
                'form' => $form,
            ]));
        }
    }


    public function edit() {
        if ($this->comment && $this->comment->canEdit()) {
            $form = StatusComment::form($this->comment);
            if ($form->isSuccess()) {
                $this->comment->apply($form->getValues());
                Output::i()->redirect($this->comment->status()->url());
            } else {
                Output::i()->add(Template::i()->renderTemplate('editComment', [
                    'form' => $form,
                ]));
            }
        } else if ($this->status && $this->status->canEdit()) {
            $form = Status::form($this->status);
            if ($form->isSuccess()) {
                $this->status->apply($form->getValues());
                Output::i()->redirect($this->status->url());
            } else {
                Output::i()->add(Template::i()->renderTemplate('edit', [
                    'form' => $form,
                ]));
            }
        } else {
            Output::i()->redirect('?');
        }
    }



    public function execute()
    {
        if (isset(Request::i()->status_id) && ctype_digit(Request::i()->status_id)) {
            $this->status = Status::load(Request::i()->status_id);
        }
        if (isset(Request::i()->comment_id) && ctype_digit(Request::i()->comment_id)) {
            $this->comment = StatusComment::load(Request::i()->comment_id);
        }
        Output::i()->title = 'Statusy';
        $this->breadcrumb = [[
            'name' => 'Statusy',
            'url' => '?controller=statuses'
        ]];
    }
}
