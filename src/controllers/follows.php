<?php

class Follows extends Controller {
    public $forum = null;
    public $breadcrumb;

    public function manage()
    {
        $follows = array_map(function($f){
            return $f->followed_id;
        },User::loggedIn()->followed());
        $posts = [];
        if (count($follows)) {
            $followers = implode(', ', $follows);
            foreach(DB::i()->query("select * from posts where author_id in ($followers) order by created desc limit 25") as $row) {
                $posts[] = new Post($row);
            }
        }


        Output::i()->add(Template::i()->renderTemplate('list', [
            'posts' => $posts,
        ]));
    }



    public function execute()
    {
        Output::i()->title = 'Tablica';
        $this->breadcrumb = [[
            'name' => 'Tablica',
            'url' => '?controller=follows'
        ]];
    }
}
