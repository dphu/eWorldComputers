<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

define('__STACKSTATIC__', md5(session_id() . 'STACKSTATIC'));

class STACKSTATIC {

    //emty STACK
    private static function clear() {
        if (isset($_SESSION[__STACKSTATIC__])) {
            unset($_SESSION[__STACKSTATIC__]);
        }
    }

    //is empty
    private static function isEmpty() {
        return (!isset($_SESSION[__STACKSTATIC__]) || !is_array($_SESSION[__STACKSTATIC__]) || !count($_SESSION[__STACKSTATIC__])) ? TRUE : FALSE;
    }

    //create
    private static function create() {
        if (STACKSTATIC::isEmpty()) {
            $_SESSION[__STACKSTATIC__] = array();
        }
    }

    public static function push($value) {
        STACKSTATIC::create();
        $_SESSION[__STACKSTATIC__][count($_SESSION[__STACKSTATIC__])] = $value;
    }

    public static function pop() {
        if (STACKSTATIC::isEmpty()) {
            return NULL;
        } else {
            $value = $_SESSION[__STACKSTATIC__][count($_SESSION[__STACKSTATIC__]) - 1];
            if (count($_SESSION[__STACKSTATIC__]) <= 1) {
                STACKSTATIC::clear();
            } else {
                unset($_SESSION[__STACKSTATIC__][count($_SESSION[__STACKSTATIC__]) - 1]);
            }
            return $value;
        }
    }

}

//end class
?>