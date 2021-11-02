<?php

class Register extends Controller {
    public static $breadcrumb = [
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
            $form = User::registerForm();
            if ($form->isSuccess()) {
                $formValues = $form->getValues();
                $registeredUser = User::register($formValues);
                if ($registeredUser) {
                    User::forceLogin($registeredUser);
                    Output::i()->redirect('?');
                } else {
                    Output::i()->add(Template::i()->renderTemplate('form', [
                        'form' => $form,
                        'error'=> 'Użytkownik o takiej nazwie lub emailu już istnieje!'
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
