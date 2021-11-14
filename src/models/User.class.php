<?php

class User extends ActiveRecord
{
    public static $cache = [];
    public static $cached_logged_in = null;
    public static $databaseTable = 'members';
    public static $idColumn = 'member_id';
    public static $columnNames = [
        'member_id',
        'name',
        'email',
        'joined',
        'password_hash',
        'is_admin',
        'about'
    ];

    public static function load($id) {
        if (array_key_exists($id, User::$cache)) {
            return User::$cache[$id];
        } else {
            $entity = parent::load($id);
            if ($entity) {
                User::$cache[$entity->member_id] = $entity;
            }
            return $entity;
        }
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function canDelete() {
        return User::loggedIn()->isAdmin() && $this->member_id != User::loggedIn()->member_id;
    }

    public static function loggedIn()
    {
        if (array_key_exists('user', $_SESSION)) {
            return User::load($_SESSION['user']);
        } else {
            return null;
        }
    }

    public function reputation() {
        $q = DB::i()->query("select count(*) as c from reactions r join posts p on r.post_id = p.post_id where p.author_id={$this->member_id}")->fetch();
        return $q['c'];
    }

    public function editForm() {
        return static::form($this);
    }

    public static function registerForm($e = null) {
        $form = new \Nette\Forms\Form();
        $form->addText('name', 'Login:')
            ->setRequired('Wypełnij pole login!')
            ->addRule($form::MIN_LENGTH, 'Login musi mieć minimum 4 znaki!', 4)
            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
            ->addRule($form::PATTERN_ICASE, "Login może się składać tylko ze znaków alfanunmerycznych oraz _ oraz -.", "^[ żółćęśąźńa-z0-9_-]+$");
        $form->addEmail('email', 'Email:')
            ->setRequired('Wypełnij pole email!')
            ->addRule($form::EMAIL, 'Wpisz poprawny adres email!')
            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255);
        $form->addPassword('password', 'Hasło:')
            ->setRequired('Wypełnij hasło!')
            ->addRule($form::MIN_LENGTH, 'Hasło musi mieć minimum 4 znaki!', 4)
            ->addRule($form::MAX_LENGTH, 'Hasło musi mieć maksimum 72 znaków!', 72);
        $form->addPassword('password_verify', 'Powtórz hasło:')
            ->setRequired('Powtórz hasło!')
            ->addRule($form::EQUAL, 'Password mismatch', $form['password'])
            ->setOmitted();
        $form->addSubmit('send', 'Zarejestruj');
        return $form;
    }

    public static function form($e = null) {
        $form = new \Nette\Forms\Form();
        // name
        $form->addText('name', 'Login:')
             ->setRequired('Wypełnij pole login!')
             ->setDefaultValue($e?->name)
             ->addRule($form::MIN_LENGTH, 'Login musi mieć minimum 4 znaki!', 4)
             ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
             ->addRule($form::PATTERN_ICASE, "Login może się składać tylko ze znaków alfanunmerycznych oraz _ oraz -.", "^[ żółćęśąźńa-z0-9_-]+$")
             ->addRule(function($name, $member_id) {
                 return User::loadAll([
                     ['name=?', $name->getValue()],
                     ['member_id!=?', $member_id]
                 ], true) == 0;
             }, 'Login jest już zajęty!', $e->member_id);

        $form->addEmail('email', 'Email:')
            ->setDefaultValue($e?->email)
            ->setRequired('Wypełnij pole email!')
            ->addRule($form::EMAIL, 'Wpisz poprawny adres email!')
            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
            ->addRule(function($name, $member_id) {
                return User::loadAll([
                        ['email=?', $name->getValue()],
                        ['member_id!=?', $member_id]
                    ], true) == 0;
            }, 'Email jest już zajęty!', $e->member_id);

        $form->addPassword('password', 'Hasło:')
            ->addRule($form::MIN_LENGTH, 'Hasło musi mieć minimum 4 znaki!', 4)
            ->addRule($form::MAX_LENGTH, 'Hasło musi mieć maksimum 72 znaków!', 72);
        $form->addPassword('password_verify', 'Powtórz hasło:')
            ->addRule($form::EQUAL, 'Password mismatch', $form['password'])
            ->setOmitted();

        $form->addTextArea('about', 'O mnie:')
            ->setDefaultValue($e->about)
            ->addRule($form::MAX_LENGTH, 'Opis może mieć maksymalnie 10000 znaków!', 1000);

        if (User::loggedIn()->isAdmin()) {
            $form->addText('joined', 'Data dołączenia:')
                ->setHtmlType('datetime-local')
                ->setRequired('Uzupełnij datę dołączenia!')
                ->addRule("Post::validateDate", "Data musi być w poprawnym formacie!")
                ->setDefaultValue(date('Y-m-d\TH:i', strtotime($e->joined)))
                ->addFilter(function ($v) {
                    return date("Y-m-d H:i:s", strtotime($v));
                });

            $form->addCheckbox('is_admin', 'Is Administrator?')
                ->setDefaultValue($e?->is_admin);

        }

        $form->addSubmit('send', 'Zarejestruj');
        return $form;
    }

    public static function loginForm() {
        $form = new \Nette\Forms\Form();
        $form->addText('name')
             ->setRequired('Wypełnij pole login!')
             ->setHtmlAttribute('placeholder', 'Login');
        $form->addPassword('password')
             ->setRequired('Wypełnij hasło!')
             ->setHtmlAttribute('placeholder', 'Hasło');
        $form->addSubmit('send', 'Zaloguj');
        return $form;
    }

    public static function register($params) {
        $users = static::loadAll([
            ['name=? or email=?', [$params['name'], $params['email']]]
        ]);
        if (count($users)) {
            return null;
        } else {
            $params['password_hash'] = password_hash($params['password'], PASSWORD_DEFAULT);
            unset($params['password']);
            $user = new static($params);
            $user->_new = true;
            $user->save();
            return $user;
        }
    }
    public static function forceLogin($user) {
        static::$cached_logged_in = null;
        //$_SESSION['user'] = User::load($user->member_id); // refresh info
    }

    public static function login($login, $password)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $accounts = DB::i()->select(
            [
                'select' => '*',
                'from' => static::$databaseTable,
                'where' => [
                    ['name=?', $login]
                ]
            ]
        );
        if ($accounts == null) {
            return null;
        }
        $user = new User($accounts[0]);
        if (password_verify($password, $user->password_hash)) {
            $_SESSION['user'] = $user->member_id;
            return $user;
        } else {
            return null;
        }
    }

    public function url() {
        return '?controller=members&member_id=' . $this->member_id;
    }

    public function link() {
        return "<a href=\"{$this->url()}\">{$this->name}</a>";
    }

    public function avatarUrl() {
        return '/assets/img/avatars/' . strtolower($this->name[0]) . '.png';
    }

    public function avatar($size = 'small') {
        return "<a href=\"{$this->url()}\"><img class=\"photo {$size}\" src=\"{$this->avatarUrl()}\" alt=\"\"></a>";
    }

    public function group() {
        if ($this->isAdmin()) {
            return "<span class=\"admin\">Administrator</span>";
        } else {
            return "<span>Użytkownik</span>";
        }
    }

    public static function logout()
    {
        $_SESSION['user'] = null;
        session_destroy();
    }

    public function canEdit() {
        return User::loggedIn()->member_id == $this->member_id || User::loggedIn()->isAdmin();
    }

    public function canFollow() {
        return $this->member_id != User::loggedIn()->member_id;
    }

    public function postCount() {
        return Post::loadAll([
            ['author_id=?', $this->member_id]
        ], true);
    }

    public function isFollowed() {
        $followers = Follow::loadAll([
            ['follower_id=?', User::loggedIn()->member_id],
            ['followed_id=?', $this->member_id],
        ]);
        if (count($followers)) {
            return $followers[0];
        } else {
            return null;
        }
    }

    public function followers($count = false) {
        return Follow::loadAll([
            ['followed_id=?', $this->member_id]
        ], $count);
    }

    public function followed($count = false) {
        return Follow::loadAll([
            ['follower_id=?', $this->member_id]
        ], $count);
    }
}