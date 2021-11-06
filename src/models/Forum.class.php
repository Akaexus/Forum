<?php

class Forum extends ActiveRecord
{

    public static $databaseTable = 'forums';
    public static $idColumn = 'forum_id';
    public static $columnNames = [
        'forum_id',
        'name',
        'description',
    ];
    public $lastPost = null;

    public static function form($entity = null) {
        $form = new \Nette\Forms\Form();
        $form->addText('name', 'Nazwa forum:')
            ->setRequired('Wypełnij nazwę forum:')
            ->addRule($form::MIN_LENGTH, 'Login musi mieć minimum 4 znaki!', 4)
            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
            ->setDefaultValue($entity?->name);
        $form->addTextArea('description', 'Opis:')
            ->setDefaultValue($entity?->description)
            ->addRule($form::MAX_LENGTH, 'Opis może mieć maksymalnie 1000 znaków!', 1000);
        $form->addSubmit('send', 'Edytuj');
        return $form;
    }

    public function url() {
        return '?controller=forums&forum_id=' . $this->forum_id;
    }

    public function getTopics() {
        return Topic::loadAll([
            ['forum_id = ?', $this->forum_id]
        ]);
    }

    public function lastPost() {
        if (!$this->lastPost) {
            $q = DB::i()->select([
                'select'=> 'getLastForumPost(forum_id) as pid',
                'from'=> static::$databaseTable,
                'where'=> [
                    ["forum_id = ?", $this->forum_id]
                ]
            ]);
            if (!$q[0]['pid']) {
                return null;
            }
            $this->lastPost = Post::load($q[0]['pid']);
        }
        return $this->lastPost;
    }

    public function countTopics() {
        return Topic::loadAll([
            ['forum_id = ?', $this->forum_id]
        ], true);
    }
}