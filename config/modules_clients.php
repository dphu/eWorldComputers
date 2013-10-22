<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f)) {
        $f = '../' . $f;
    }
    die(header('Location: ' . $f));
}

$config['modules_clients'] = array(
    'getblock',
    'contact',
    'banggia',
    'category',
    'pressandnews',
    'storecatalor',
);
?>