<?php

class Follow extends ActiveRecord
{

    public static $databaseTable = 'followers';
    public static $idColumn = 'follow_id';
    public static $columnNames = [
        'followed_id',
        'follower_id'
    ];

    public function followed() {
        return User::load($this->followed_id);
    }
    public function follower() {
        return User::load($this->follower_id);
    }
}