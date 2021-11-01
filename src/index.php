<?php
require_once 'utils/autoload.php';
require_once 'vendor/autoload.php';

const ROOT_PATH = __DIR__ . '/';
session_start();
Output::i()->add('dupa');
Output::i()->render();