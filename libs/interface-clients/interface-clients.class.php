<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

class INTERFACE_CLIENTS {

    //contructor
    public function __construct() {
        //null
    }

    //destructor
    public function __destruct() {
        //null
    }

    //load config
    public function loadInterfaceConfig(&$db = NULL) { //using for clients
        if (!is_object($db)) {
            global $db;
        }

        $db->query(
                "SELECT 
							REPLACE(UPPER(`name`), ' ', '_') AS `name`, 
							`value_{$_SESSION['lang']}` AS `value` 
					FROM `tbl_interface_config`"
        );
        if ($db->numRows()) {
            while ($row = $db->fetchRow()) {
                defined("{$row->name}") or define("{$row->name}", "{$row->value}");
            }
        }
    }

//end function
}

//end class
?>