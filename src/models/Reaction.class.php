<?php

class Reaction extends ActiveRecord
{

    public static $databaseTable = 'reactions';
    public static $idColumn = 'reaction_id';
    public static $columnNames = [
        'member_id',
        'post_id'
    ];

    public function member() {
        return User::load($this->member_id);
    }

    public function post() {
        return Post::load($this->post_id);
    }

}