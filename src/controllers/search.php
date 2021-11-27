<?php

class Search extends Controller {
    public $breadcrumb;
    public $needle = null;
    public  $modules = null;
    public function manage()
    {
        $form = static::form();
        if ($form->isSuccess()) {
            if ($form->getValues()->search) {
                $needle = $form->getValues()->search;
            }
        }

        if (!$this->needle && isset(Request::i()->search)) {
            $this->needle = Request::i()->search;
            if (strlen($this->needle) < 3 ||  strlen($this->needle) > 255) {
                Output::i()->error('S/001', 'Wyszukiwana fraza jest zbyt długa lub krótka!', 'Wyszukiwana fraza może zawierać od 3 do 255 znaków!');
                return;
            }
        }

        $category = 'posts';
        if (isset(Request::i()->category) && array_key_exists(Request::i()->category, $this->modules)) {
            $category = Request::i()->category;
        }

        Output::i()->add(Template::i()->renderTemplate('list', [
            'needle' => $this->needle,
            'categories'=> $this->modules,
            'activeCategory' => $category,
            'entities'=> array_map(function($e) use ($category) {
                return new $this->modules[$category]['entity']($e);
            }, $this->modules[$category]['fetch']($this->needle)),
        ]));
    }

    public static function form() {
        $form = new \Nette\Forms\Form();
        $form->setAction('?controller=search');
        $form->addText('search')
            ->setRequired('Wypisz frazę do wyszukania!')
            ->addRule($form::MIN_LENGTH, 'Login musi mieć minimum 3 znaki!', 3)
            ->addRule($form::MAX_LENGTH, 'Login musi mieć maksimum 255 znaków!', 255)
            ->setHtmlAttribute('placeholder', 'szukaj...');
        $form->addSubmit('send', 'szukaj')
            ->setHtmlId('search-submit')
            ->setHtmlAttribute('style', 'display: none;');
        return $form;
    }

    public function execute()
    {
        Output::i()->title = 'Szukaj';
        $this->breadcrumb = [[
            'name' => 'Szukaj',
            'url' => '?controller=search'
        ]];

        $this->modules = [
            'announcements'=> [
                'lang'=> 'Ogłoszenia',
                'entity'=> 'Announcement',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('select * from announcements where title like CONCAT(\'%\', ?, \'%\') or match(content) against (? in natural language mode)', [$needle, $needle]);
                },
            ],
            'forums' => [
                'lang'=> 'Subfora',
                'entity'=> 'Forum',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('select * from forums where name like CONCAT(\'%\', ?, \'%\') or match(description) against (? in natural language mode)', [$needle, $needle]);
                },
            ],
            'topics'=> [
                'lang'=> 'Tematy',
                'entity'=> 'Topic',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('select * from topics where title like CONCAT(\'%\', ?, \'%\')', [$needle]);
                },
            ],
            'posts'=> [
                'lang'=> 'Posty',
                'entity'=> 'Post',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('select * from posts where match(content) against (? in natural language mode)', [$needle]);
                },
            ],
            'members' => [
                'lang' => 'Użytkownicy',
                'entity'=> 'User',
                'fetch'=> function($needle) {
                    if (User::loggedIn()->isAdmin()) {
                        return DB::i()->queryParams('select * from members where name like CONCAT(\'%\', ?, \'%\') or email like CONCAT(\'%\', ?, \'%\') or match(about) against (? in natural language mode)', [$needle, $needle, $needle]);
                    } else {
                        return DB::i()->queryParams('select * from members where name like CONCAT(\'%\', ?, \'%\') or match(about) against (? in natural language mode)', [$needle, $needle]);
                    }
                },
            ],
            'reactions' => [
                'lang' => 'Reakcje',
                'entity'=> 'Reaction',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('
                        select *
                        from reactions r
                        join posts p on r.post_id = p.post_id
                        join members m on m.member_id = r.member_id
                        where
                            m.name like CONCAT(\'%\', ?, \'%\')
                            or match(p.content) against (? in natural language mode) 
                    ', [$needle, $needle]);
                },
            ],
            'status_comments'=> [
                'lang' => 'Komentarze statusów',
                'entity'=> 'StatusComment',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('
                        select *
                        from status_comments sc
                        where
                            match(sc.content) against (? in natural language mode) 
                    ', [$needle]);
                },
            ],
            'statuses'=> [
                'lang'=> 'Statusy',
                'entity'=> 'Status',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('
                        select *
                        from statuses s
                        where
                            match(s.content) against (? in natural language mode) 
                    ', [$needle]);
                },
            ],
            'trophies'=> [
                'lang'=> 'Trofea',
                'entity'=> 'Trophy',
                'fetch'=> function($needle) {
                    return DB::i()->queryParams('
                        select t.*
                        from trophies t
                        join members giver on giver.member_id = t.giver_id
                        join members given on given.member_id = t.given_id
                        where
                            match(t.description) against (? in natural language mode)
                            or giver.name like CONCAT(\'%\', ?, \'%\')
                            or given.name like CONCAT(\'%\', ?, \'%\')
                    ', [$needle, $needle, $needle]);
                },
            ]
        ];
    }
}
