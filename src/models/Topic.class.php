<?php

class Topic extends ActiveRecord
{

    public static $databaseTable = 'topics';
    public static $idColumn = 'topic_id';
    public static $columnNames = [
        'topic_id',
        'title',
        'created',
        'forum_id',
        'author_id'
    ];

    public function firstPost() {
        $q = DB::i()->select([
            'select'=> '*',
            'from'=> Post::$databaseTable,
            'where'=> [
                ['topic_id = ?', $this->topic_id]
            ],
            'order'=> 'post_id asc',
            'limit'=> 1
        ]);
        return count($q) ? new Post($q[0]) : null;
    }

    public static function form($entity = null) {
        $form = new \Nette\Forms\Form();
        $form->addText('title', 'Nazwa tematu:')
            ->setRequired('Wypełnij nazwę tematu:')
            ->addRule($form::MIN_LENGTH, 'Login musi mieć minimum 1 znak!', 1)
            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
            ->setDefaultValue($entity?->title);
        $form->addTextArea('content', 'Treść:')
            ->setDefaultValue($entity?->firstPost()?->content)
            ->addRule($form::MAX_LENGTH, 'Opis może mieć maksymalnie 10000 znaków!', 1000);

        if ($entity && User::loggedIn()->isAdmin()) {

            $fid = $entity->forum()->forum_id;
            $forums = Forum::loadAll();

            $forums_options = [];
            foreach ($forums as $forum) {
                $forums_options[$forum->forum_id] = $forum->name;
            }

            $form->addSelect('forum_id', 'Forum', $forums_options)
                ->setRequired('Uzupełnij forum tematu!')
                ->setDefaultValue($fid);

            // authors
            $members = User::loadAll();
            $members_options = [];
            foreach ($members as $member) {
                $members_options[$member->member_id] = $member->name;
            }
            $form->addSelect('author_id', 'Autor', $members_options)
                ->setDefaultValue($entity->author_id);

            $form->addText('created', 'Data utworzenia:')
                ->setHtmlType('datetime-local')
                ->setRequired('Uzupełnij datę utworzenia posta!')
                ->addRule("Post::validateDate", "Data musi być w poprawnym formacie!")
                ->setDefaultValue(date('Y-m-d\TH:i', strtotime($entity->created)))
                ->addFilter(function ($v) {
                    return date("Y-m-d H:i:s", strtotime($v));
                });
        }

        $form->addSubmit('send', 'Dodaj');
        return $form;
    }

    public function posts() {
        return Post::loadAll([
            ['topic_id = ?', $this->topic_id]
        ]);
    }

    public function countPosts() {
        return Post::loadAll([
            ['topic_id = ?', $this->topic_id]
        ], true);
    }

    public function lastPost() {
        $posts = DB::i()->select([
            'select'=> '*',
            'from'=> Post::$databaseTable,
            'where'=> [
                ['topic_id = ?', $this->topic_id]
            ],
            'order'=> 'created desc',
            'limit'=> 1
        ]);
        if (count($posts)) {
            return new Post($posts[0]);
        } else {
            return null;
        }
    }

    public function url($postID = null) {
        return '?controller=topics&topic_id=' . $this->topic_id . ($postID ? "#post-{$postID}" : '');
    }

    public function link($postID = null) {
        return "<a href=\"{$this->url($postID)}\">{$this->title}</a>";
    }

    public function author() {
        return User::load($this->author_id);
    }

    public function canEdit() {
        return User::loggedIn()->member_id == $this->author_id || User::loggedIn()->isAdmin();
    }

    public function forum() {
        return Forum::load($this->forum_id);
    }
}