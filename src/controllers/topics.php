<?php

class Topics extends Controller {
    public $topic = null;
    public $breadcrumb;
    public function manage()
    {
        $postForm = Post::form();
        if ($postForm->isSuccess()) {
            $post_data = $postForm->getValues();
            $post_data['author_id'] = User::loggedIn()->member_id;
            $post_data['topic_id'] = $this->topic->topic_id;
            $post = new Post($post_data);
            $post->_new = true;
            $post->save();
            Output::i()->redirect($post->url());
        }
        Output::i()->add(Template::i()->renderTemplate('topic', [
            'topic' => $this->topic,
            'postForm'=> Post::form()
        ]));
    }



//    public function edit() {
//        if (User::loggedIn()->isAdmin()) {
//            Output::i()->title = 'Edytuj ' . $this->forum->name;
//            $form = Forum::form($this->forum);
//            if ($form->isSuccess()) {
//                $this->forum->apply($form->getValues());
//                Output::i()->redirect($this->forum->url());
//            } else {
//                Output::i()->add(Template::i()->renderTemplate('edit', [
//                    'forum' => $this->forum,
//                    'form' => $form
//                ]));
//            }
//        }
//    }

    public function execute()
    {
        if (isset(Request::i()->topic_id) && ctype_digit(Request::i()->topic_id)) {
            $this->topic = Topic::load(Request::i()->topic_id);
        }

        if ($this->topic == null) {
            Output::i()->redirect('?');
        }
        Output::i()->title = $this->topic->title;
        $parent_forum = $this->topic->forum();
        $this->breadcrumb = [
            [
                'name'=> $parent_forum->name,
                'url'=> $parent_forum->url(),
            ],
            [
                'name'=> $this->topic->title,
                'url'=> $this->topic->url(),
            ]
        ];
    }
}
