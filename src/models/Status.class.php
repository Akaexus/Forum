<?php

class Status extends ActiveRecord
{

    public static $databaseTable = 'statuses';
    public static $idColumn = 'status_id';
    public static $columnNames = [
        'status_id',
        'author_id',
        'created',
        'content'
    ];

    public function author() {
        return User::load($this->author_id);
    }

    public static function form($entity = null) {
        $form = new \Nette\Forms\Form();
        $form->addTextArea('content', 'Treść statusu:')
            ->setRequired('Wypełnij treść statusu:')
            ->addRule($form::MIN_LENGTH, 'Status musi mieć minimum 1 znak!', 1)
            ->addRule($form::MAX_LENGTH, 'Status musi mieć maksimum 300 znaków!', 1000)
            ->setDefaultValue($entity?->content);

        if ($entity && User::loggedIn()->isAdmin()) {
            // authors
            $members = User::loadAll();
            $members_options = [];
            foreach ($members as $member) {
                $members_options[$member->member_id] = $member->name;
            }
            $form->addSelect('author_id', 'Autor', $members_options)
                ->setRequired('Podaj autora statusu!')
                ->setDefaultValue($entity->author_id);

            $form->addText('created', 'Data')
                ->setHtmlType('datetime-local')
                ->setRequired('Uzupełnij datę!')
                ->addRule("Post::validateDate", "Data musi być w poprawnym formacie!")
                ->setDefaultValue(date('Y-m-d\TH:i', strtotime($entity->created)))
                ->addFilter(function ($v) {
                    return date("Y-m-d H:i:s", strtotime($v));
                });
        }

        $form->addSubmit('send', $entity ? 'Edytuj' : 'Dodaj');
        return $form;
    }

    public function comments($count = false) {
        return StatusComment::loadAll([
            ['status_id=?', $this->status_id]
        ], $count);
    }

    public function url() {
        return '?controller=statuses&status_id=' . $this->status_id;
    }

    public function commentForm() {
        $form = StatusComment::form(null, $this->status_id);
        return $form;
    }

    public function canEdit() {
        return User::loggedIn()->isAdmin() || User::loggedIn()->member_id == $this->author_id;
    }
}