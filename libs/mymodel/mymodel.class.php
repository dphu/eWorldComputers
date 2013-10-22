<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
}

/*
  coding: Mai Ngoc My
  email: maingocmy2003@yahoo.com
  Mobi: 0986174211
 */

class __MYMODEL {

    //do query
    public static function __doQuery($sql, &$db, $debug = FALSE) {
        if ($debug) {
            return view($sql);
        }

        $db->query($sql);

        return NULL;
    }

    //end function
    //do select (1 table)
    public static function __doSELECT(&$db, $fileds, $table, $where, $groupBy, $orderBy, $limit, $returnType, $debug = FALSE) {
        $sql = "
								SELECT {$fileds}
								FROM {$table}
								{$where}
								{$groupBy}
								{$orderBy}
								{$limit}
							 ";
        __MYMODEL::__doQuery($sql, $db, $debug);

        return $db->numRows() ? $db->{$returnType}() : NULL;
    }

    //end function
    //do update
    public static function __doUPDATE(&$db, $table, $sets, $where = '', $limit = '', $debug = FALSE) {
        __MYMODEL::__doQuery("UPDATE `{$table}` SET " . implode(', ', $sets) . " {$where} {$limit}", $db, $debug);

        return NULL;
    }

    //end function
    //do insert
    public static function __doINSERT(&$db, $table, $fields, $values, $debug = FALSE) {
        __MYMODEL::__doQuery("INSERT INTO `{$table}` (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")", $db, $debug);

        return NULL;
    }

    //end function
    //do delete
    public static function __doDELETE(&$db, $table, $where, $limit = '', $debug = FALSE) {
        return __MYMODEL::__doQuery("DELETE FROM `{$table}` {$where} {$limit}", $db, $debug);
    }

    //end function
}

//end class
?>