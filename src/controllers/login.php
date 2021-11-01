<?php

class Login extends Controller {
    public function manage()
    {
        Output::i()->add('manage');
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
        Output::i()->showHeader = false;
        Output::i()->showFooter = false;
        Output::i()->showBreadcrumb = false;
    }
}
