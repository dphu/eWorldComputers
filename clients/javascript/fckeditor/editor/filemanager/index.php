<?php if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
}; ?>