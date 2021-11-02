<?php

class Login extends Controller {
    public static $breadcrumb = [
        [
            'name'=> 'Zaloguj',
            'url'=> '?controller=login'
        ]
    ];
    public function manage()
    {
        $form = User::loginForm();
        if ($form->isSuccess()) {
            $formValues = $form->getValues();
            Output::i()->add('<pre>');
            Output::i()->add(print_r($formValues, 1));
            Output::i()->add('</pre>');
        } else {
            Output::i()->add(Template::i()->renderTemplate('form', [
                'form'=> $form
            ]));
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
