<?php

class Post extends ActiveRecord
{

    public static $databaseTable = 'posts';
    public static $idColumn = 'post_id';
    public static $columnNames = [
        'post_id',
        'topic_id',
        'author_id',
        'created',
        'content'
    ];

    public function author() {
        return User::load($this->author_id);
    }

    public function topic() {
        return Topic::load($this->topic_id);
    }
//
//    public static function form($entity = null) {
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
//    }
//
//    public function url() {
//        return '?controller=forums&forum_id=' . $this->forum_id;
//    }
//
//    public function getTopics() {
//        return Topic::loadAll([
//            ['forum_id = ?', $this->forum_id]
//        ]);
//    }
}