<?php

class User extends ActiveRecord
{

    public static $databaseTable = 'members';
    public static $idColumn = 'member_id';
    public static $columnNames = [
        'member_id',
        'name',
        'email',
        'joined',
        'posts',
        'topics'
    ];


    public static function loggedIn()
    {
        if (array_key_exists('user', $_SESSION)) {
            return $_SESSION['user'];
        } else {
            return null;
        }
    }


    public static function login($login, $password)
    {
        $accounts = DB::i()->select(
            [
                'select' => '*',
                'from' => static::$databaseTable,
                'where' => [
                    ['login=?', $login],
                    ['pass=?', $password]
                ]
            ]
        );
        if ($accounts == null) {
            return null;
        } else {
            $user = new User($accounts[0]);
            $_SESSION['user'] = $user;
            return $user;
        }
    }

    public static function logout()
    {
        $_SESSION['user'] = null;
        session_destroy();
    }
}