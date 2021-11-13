<?php

class Members extends Controller {
    public $breadcrumb = null;
    public $member = null;
    public function manage()
    {
        Output::i()->add(Template::i()->renderTemplate('member', [
            'member' => $this->member,
        ]));
    }
    public function execute()
    {
        Output::i()->showHeader = true;
        Output::i()->showFooter = true;
        Output::i()->showBreadcrumb = true;
        if (isset(Request::i()->do) && Request::i()->do == 'list') {
            $this->breadcrumb = [[
                'name' => 'Użytkownicy',
                'url' => '?controllers=members&do=list',
            ]];
            Output::i()->title = 'Użytkownicy';
        } else {
            if (isset(Request::i()->member_id) && ctype_digit(Request::i()->member_id)) {
                $this->member = User::load(Request::i()->member_id);
            }
            if ($this->member) {
                Output::i()->title = $this->member->name;

                $this->breadcrumb = [[
                    'name' => $this->member->name,
                    'url' => $this->member->url()
                ]];
            } else {
                Output::i()->redirect('?');
            }
        }
    }

    public function list() {
        Output::i()->add(Template::i()->renderTemplate('list', [
            'members' => User::loadAll(),
        ]));
    }

    public function follow() {
        if (User::loggedIn()->member_id != $this->member->member_id) {
            $follow = $this->member->isFollowed();
            if ($follow) {
                $follow->delete();
            } else {
                $follow = new Follow([
                    'followed_id' => $this->member->member_id,
                    'follower_id' => User::loggedIn()->member_id,
                ]);
                $follow->_new = true;
                $follow->save();
            }
        }
        Output::i()->redirect($this->member->url());
    }
}
