<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

$config['modules'] = array(
    'changehost',
    'imagesmanager',
    'flashesmanager',
    'ajax_manager',
    'account',
    'config',
//'langconfig',
    'logout',
    'catnews',
    'news',
    'admineditordesign_manager',
    'block',
    'blockid_manager',
    'banggia',
    'banggiaimages',
// admin block
    'edit_template',
    'thietbi-pro-cat',
    'thietbi-product',
    'thietbi-productimages',
    'state',
    'dealers',
);
?>