<?php

class Login extends Controller {
    public $breadcrumb = [
        [
            'name'=> 'Zaloguj',
            'url'=> '?controller=login'
        ]
    ];
    public function manage()
    {
        if (User::loggedIn()) {
            Output::i()->redirect('?');
        } else {
            $form = User::loginForm();
            if ($form->isSuccess()) {
                $formValues = $form->getValues();
                $user = User::login($formValues['name'], $formValues['password']);
                if ($user) {
                    Output::i()->redirect('?');
                } else {
                    Output::i()->add(Template::i()->renderTemplate('form', [
                        'form' => $form,
                        'error' => 'Nazwa konta lub hasło nieprawidłowe'
                    ]));
                }
            } else {
                Output::i()->add(Template::i()->renderTemplate('form', [
                    'form' => $form
                ]));
            }
        }
    }
    public function execute()
    {
        Output::i()->title = 'Zaloguj';
        Output::i()->showHeader = true;
        Output::i()->showFooter = true;
        Output::i()->showBreadcrumb = true;
    }
}
