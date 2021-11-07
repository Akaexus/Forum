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

    public function canEdit() {
        return User::loggedIn()->member_id == $this->author_id || User::loggedIn()->isAdmin();
    }

    public static function form($entity = null) {
        $form = new \Nette\Forms\Form();
        $isAdmin = User::loggedIn()->isAdmin();
        if ($entity && $isAdmin) {
            $topics = Topic::loadAll();
            $topic_options = [];
            foreach ($topics as $topic) {
                $topic_options[$topic->topic_id] = "[{$topic->topic_id}] $topic->title";
            }

            $form->addSelect('topic_id', 'Temat:', $topic_options)
                ->setRequired()
                ->setDefaultValue($entity->topic_id);

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

        $form->addTextArea('content', 'Treść:')
            ->setRequired('Uzupełnij treść posta!')
            ->setDefaultValue($entity?->content)
            ->addRule($form::MAX_LENGTH, 'Post może mieć maksymalnie 10000 znaków!', 10000);
        $form->addSubmit('send', $entity ? 'Edytuj' : 'Dodaj');
        return $form;
    }
    public static function validateDate($input) {
        return strtotime($input->getValue());
    }

    public function url() {
        return $this->topic()->url($this->post_id);
    }

}