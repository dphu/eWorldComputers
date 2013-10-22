<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

class AJAXSECURITY {

    private static function __GetPrefix() {
        return md5('AJAXSECURITY' . session_id());
    }

    private static function __GetKey() {
        return md5('SECURITY' . session_id());
    }

    private static function __GetKeyValue() {
        return md5(strrev(session_id()));
    }

    public static function GetKey() {
        $prefix = AJAXSECURITY::__GetPrefix();
        $keyName = 'ajxsecuritykey=';
        $key = AJAXSECURITY::__GetKey();

        return isset($_SESSION[$prefix][$key]) ? $keyName . $_SESSION[$prefix][$key] : $keyName;
    }

    public static function CreateKey() {
        $_SESSION[AJAXSECURITY::__GetPrefix()][AJAXSECURITY::__GetKey()] = AJAXSECURITY::__GetKeyValue();
    }

    public static function Clear() {
        $prefix = AJAXSECURITY::__GetPrefix();

        if (isset($_SESSION[$prefix])) {
            unset($_SESSION[$prefix]);
        }
    }

    public static function IsSecurity($posted = FALSE) {
        $prefix = AJAXSECURITY::__GetPrefix();
        $key = AJAXSECURITY::__GetKey();

        if (!isset($_SESSION[$prefix][$key])) {
            return FALSE;
        } else {
            return (!$posted || (IO::getPOST('ajxsecuritykey') == AJAXSECURITY::__GetKeyValue())) ? TRUE : FALSE;
        }
    }

}

//end class
?>