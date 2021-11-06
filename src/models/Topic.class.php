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

    public static function form($entity = null) {
//        $form = new \Nette\Forms\Form();
//        $form->addText('name', 'Nazwa forum:')
//            ->setRequired('Wypełnij nazwę forum:')
//            ->addRule($form::MIN_LENGTH, 'Login musi mieć minimum 4 znaki!', 4)
//            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
//            ->setDefaultValue($entity?->name);
//        $form->addTextArea('description', 'Opis:')
//            ->setDefaultValue($entity?->description)
//            ->addRule($form::MAX_LENGTH, 'Opis może mieć maksymalnie 1000 znaków!', 1000);
//        $form->addSubmit('send', 'Edytuj');
//        return $form;
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

    public function url() {
        return '?controller=topics&topic_id=' . $this->topic_id;
    }

    public function link() {
        return "<a href=\"{$this->url()}\">{$this->title}</a>";
    }

    public function author() {
        return User::load($this->author_id);
    }

    public function forum() {
        return Forum::load($this->forum_id);
    }
}