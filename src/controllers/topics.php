<?php

class Topics extends Controller {
    public $topic = null;
    public $breadcrumb = [];
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

    public function add() {
        $form = Topic::form();
        if ($form->isSuccess()) {
            $v = $form->getValues();
            $topic = new Topic([
                'title'=> $v['title'],
                'forum_id'=> $this->forum->forum_id,
                'author_id'=> User::loggedIn()->member_id,
            ]);
            $topic->_new = true;
            $topic->save();

            $post = new Post([
                'topic_id'=> $topic->topic_id,
                'content'=> $v['content'],
                'author_id'=> User::loggedIn()->member_id,
            ]);
            $post->_new = true;
            $post->save();

            Output::i()->redirect($topic->url());
        } else {
            Output::i()->add(Template::i()->renderTemplate('add', [
                'forum'=> $this->forum,
                'form'=> $form,
            ]));
        }

    }

    public function edit() {
        $form = Topic::form($this->topic);
        if ($form->isSuccess()) {
            $v = $form->getValues();
            foreach (['title', 'created', 'forum_id', 'author_id'] as $key) {
                $this->topic->$key = $v[$key];
            }
            $this->topic->save();

            $firstPost = $this->topic->firstPost();
            foreach (['author_id', 'created', 'content'] as $key) {
                $firstPost->$key = $v[$key];
            }
            $firstPost->save();

            Output::i()->redirect($this->topic->url());


        } else {
            Output::i()->add(Template::i()->renderTemplate('edit', [
                'topic'=> $this->topic,
                'form'=> $form,
            ]));
        }

    }

    public function delete() {
        if ($this->topic->canEdit()) {
            DB::i()->delete([
                'from'=> 'posts',
                'where'=> [
                    ['topic_id = ?', $this->topic->topic_id]
                ]
            ]);
            $forumUrl = $this->topic->forum()->url();
            $this->topic->delete();
            Output::i()->redirect($this->topic->forum()->url());
        } else {
            Output::i()->redirect($this->topic->url());
        }
    }

    public function execute()
    {

        if (isset(Request::i()->do) && Request::i()->do == 'add') {
            Output::i()->title = 'Dodaj nowy temat';
            if (isset(Request::i()->forum_id) && ctype_digit(Request::i()->forum_id) && Request::i()->forum_id > 0) {
                $this->forum = Forum::load(Request::i()->forum_id);
                if (!$this->forum) {
                    Output::i()->redirect('?');
                } else {
                    $this->breadcrumb = [
                        [
                            'name'=> $this->forum->name,
                            'url'=> $this->forum->url(),
                        ],
                        [
                            'name'=> 'Dodaj nowy temat',
                            'url'=> '?controller=topics&do=add&forum_id=' . $this->forum->forum_id,
                        ],
                    ];
                }
            }
        } else {
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
                    'name' => $parent_forum->name,
                    'url' => $parent_forum->url(),
                ],
                [
                    'name' => $this->topic->title,
                    'url' => $this->topic->url(),
                ]
            ];
        }
    }
}
