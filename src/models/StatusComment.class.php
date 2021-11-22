<?php

class StatusComment extends ActiveRecord
{

    public static $databaseTable = 'status_comments';
    public static $idColumn = 'comment_id';
    public static $columnNames = [
        'comment_id',
        'status_id',
        'created',
        'author_id',
        'content',
    ];

    public function author() {
        return User::load($this->author_id);
    }

    public static function form($entity = null, $status_id = false) {
        $form = new \Nette\Forms\Form();
        $form->addTextArea('content', 'Treść komentarza:')
            ->setRequired('Wypełnij treść komentarza:')
            ->addRule($form::MIN_LENGTH, 'Komentarz musi mieć minimum 1 znak!', 1)
            ->addRule($form::MAX_LENGTH, 'Komentarz musi mieć maksimum 300 znaków!', 1000)
            ->setDefaultValue($entity?->content);

        if ($status_id) {
            $form->addHidden('status_id')
                -> setDefaultValue($status_id);
        }
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

    public function url() {
        return '?controller=statuses&comment_id=' . $this->comment_id;
    }

    public function status() {
        return Status::load($this->status_id);
    }

    public function canEdit() {
        return User::loggedIn()->isAdmin() || User::loggedIn()->member_id == $this->author_id;
    }
}