<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
}

//class load any data from DB
//author: maingocmy
//email: maingocmy2003@yahoo.com

class __LOAD_ANY_DATA_CLASS {

    //get data
    public static function GETDATA(&$db, $tableName) {
        if ($row = __MYMODEL::__doSELECT($db, "`desc_{$_SESSION['lang']}` AS `content`", $tableName, 'WHERE `display` = 1', 'GROUP BY `id`', 'ORDER BY `id`', 'LIMIT 1', 'fetchRow')) {
            return $row->content;
        } else {
            return NULL;
        }
    }

    //end function
    //get data ex (not multi language)
    public static function GETDATAEX(&$db, $tableName) {
        if ($row = __MYMODEL::__doSELECT($db, '`content`', $tableName, NULL, NULL, NULL, 'LIMIT 1', 'fetchRow')) {
            return $row->content;
        } else {
            return NULL;
        }
    }

    //end function
    //get data
    public static function GETDATAINTERFACE(&$db, $blockid) {
        if ($row = __MYMODEL::__doSELECT($db, "`desc_{$_SESSION['lang']}` AS `content`", 'tbl_interface_manager', "WHERE `display` = 1 AND `blockid` = '{$blockid}'", 'GROUP BY `id`', 'ORDER BY `id`', 'LIMIT 1', 'fetchRow')) {
            return $row->content;
        } else {
            return NULL;
        }
    }

    //end function
}

//end class
?>