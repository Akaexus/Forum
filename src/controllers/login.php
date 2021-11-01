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
        Output::i()->add(User::loginForm());
        if ($form->isSuccess()) {
            $formValues = $form->getValues();
            Output::i()->add('<pre>');
            Output::i()->add(print_r($formValues, 1));
            Output::i()->add('</pre>');
        }
//        if (User::loggedIn()) {
//            Output::i()->add('zalogowany');
//        } else {
//            $form = new \Nette\Forms\Form();
//            $form->addText('login')
//                ->setRequired('Wypełnij pole login.')
//                ->setHtmlAttribute('placeholder', 'Login');
//            $form->addPassword('pass')
//                ->setRequired('Wypełnij pole login.')
//                ->setHtmlAttribute('placeholder', 'Hasło');
//            $form->addSubmit('send', 'Zaloguj');
//            $template = Output::i()->renderTemplate(
//                'login',
//                'form',
//                [
//                    'form'=> $form
//                ]
//            );
//            if ($form->isSuccess()) {
//                $formValues = $form->getValues();
//                $logged = User::login($formValues['login'], $formValues['pass']);
//                if ($logged) {
//                    Output::i()->redirect('');
//                } else {
//                    Output::i()->add($template);
//                }
//            } else {
//                Output::i()->add($template);
//            }
//        }
    }
    public function execute()
    {
        Output::i()->title = 'Zaloguj';
        Output::i()->showHeader = true;
        Output::i()->showFooter = true;
        Output::i()->showBreadcrumb = true;
    }
}
