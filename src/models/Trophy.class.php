<?php

class Trophy extends ActiveRecord
{

    public static $databaseTable = 'trophies';
    public static $idColumn = 'trophy_id';
    public static $columnNames = [
        'trophy_id',
        'give_date',
        'giver_id',
        'given_id',
        'description'
    ];

    public function giver() {
        return User::load($this->giver_id);
    }

    public static function form($entity = null) {
        $form = new \Nette\Forms\Form();
        $form->addTextArea('description', 'Tytuł trofeum:')
            ->setRequired('Wypełnij tytuł trofeum:')
            ->addRule($form::MIN_LENGTH, 'Nazwa ogłoszenia musi mieć minimum 1 znak!', 1)
            ->addRule($form::MAX_LENGTH, 'Nazwa ogłoszenia musi mieć maksimum 1000 znaków!', 1000)
            ->setDefaultValue($entity?->description);

        if ($entity && User::loggedIn()->isAdmin()) {
            // authors
            $members = User::loadAll();
            $members_options = [];
            foreach ($members as $member) {
                $members_options[$member->member_id] = $member->name;
            }
            $form->addSelect('giver_id', 'Dający', $members_options)
                ->setRequired('Podaj osobę dostającą trofeum')
                ->setDefaultValue($entity->giver_id);
            $form->addSelect('given_id', 'Dostawający', $members_options)
                ->setRequired('Podaj odbiorcę trofeum')
                ->setDefaultValue($entity->given_id);

            $form->addText('give_date', 'Data')
                ->setHtmlType('datetime-local')
                ->setRequired('Uzupełnij datę!')
                ->addRule("Post::validateDate", "Data musi być w poprawnym formacie!")
                ->setDefaultValue(date('Y-m-d\TH:i', strtotime($entity->give_date)))
                ->addFilter(function ($v) {
                    return date("Y-m-d H:i:s", strtotime($v));
                });
        }

        $form->addSubmit('send', $entity ? 'Edytuj' : 'Dodaj');
        return $form;
    }

    public function given() {
        return User::load($this->given_id);
    }
}