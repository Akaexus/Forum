<?php

class Announcement extends ActiveRecord
{

    public static $databaseTable = 'announcements';
    public static $idColumn = 'announcement_id';
    public static $columnNames = [
        'announcement_id',
        'title',
        'created',
        'content',
        'author_id'
    ];

    public static function form($entity = null) {
        $form = new \Nette\Forms\Form();
        $form->addText('title', 'Nazwa ogłoszenia:')
            ->setRequired('Wypełnij nazwę ogłoszenia:')
            ->addRule($form::MIN_LENGTH, 'Nazwa ogłoszenia musi mieć minimum 1 znak!', 1)
            ->addRule($form::MAX_LENGTH, 'Nazwa ogłoszenia musi mieć maksimum 255 znaków!', 255)
            ->setDefaultValue($entity?->title);
        $form->addTextArea('content', 'Treść:')
            ->setDefaultValue($entity?->content)
            ->addRule($form::MAX_LENGTH, 'Treść może mieć maksymalnie 10000 znaków!', 1000);

        if ($entity && User::loggedIn()->isAdmin()) {

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

        $form->addSubmit('send', 'Edytuj');
        return $form;
    }


    public function url($postID = null) {
        return '?controller=announcements&announcement_id=' . $this->announcement_id;
    }

    public function link($postID = null) {
        return "<a href=\"{$this->url()}\">{$this->title}</a>";
    }

    public function author() {
        return User::load($this->author_id);
    }

    public function canDelete() {
        return User::loggedIn()->isAdmin();
    }

    public function canEdit() {
        return User::loggedIn()->isAdmin();
    }
}