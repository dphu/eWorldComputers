<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

class MULTI_LANGUAGE {

    //contructor
    public function __construct() {
        //null
    }

    //destructor
    public function __destruct() {
        //null
    }

    //auto create default lang
    public static function autoCreateDefaultLang(&$db = NULL) { //using for admin
        if (!is_object($db)) {
            global $db;
        }

        if (!$db->count_records('tbl_lang')) {
            $key = LANG_KEY;
            $description = LANG_DESC;
            //insert a default lang
            $db->query("INSERT INTO `tbl_lang` 
						(
							`id` ,
							`key` ,
							`description` ,
							`icon` ,
							`icon_hover` ,
							`icon_actived` ,
							`ordering` ,
							`display`
						)
						VALUES 
						(
							NULL , 
							'{$key}', 
							'{$description}', 
							NULL , 
							NULL , 
							NULL , 
							'0', 
							'1'
						)");
            //get records info for add
            $rows = MULTI_LANGUAGE::__getMyConfigInfo($db);

            //add fields
            if ($rows) {
                foreach ($rows as $row) {
                    if (!MULTI_LANGUAGE::__isExistField($db, $row->table, $row->field . '_' . $key)) {
                        $sql = "ALTER TABLE `{$row->table}` 
								ADD `{$row->field}_{$key}` {$row->type}
								CHARACTER SET utf8 
								COLLATE utf8_unicode_ci 
								NULL";
                        $db->query($sql);
                    }//if
                }//for	
            }//if
        }//if				
    }

//end function

    /**
     * */
    private static function __getMyConfigInfo(&$db) {
        $db->query("SELECT `table`,`field`,`type` FROM `tbl_config_fields_lang`");

        return $db->numRows() ? $db->fetchRowSet() : NULL;
    }

    //end function

    /**
     * */
    private static function __isExistField(&$db, $tableName, $fieldname) {
        $db->query("SHOW COLUMNS FROM {$tableName} LIKE '{$fieldname}'");

        return $db->numRows() ? true : false;
    }

    //end fuction
    //detect current language
    public static function autoDetectLanguage(&$db = NULL) { //using for clients page
        if (!is_object($db)) {
            global $db;
        }

        MULTI_LANGUAGE::autoCreateDefaultLang($db);

        $sql = 'SELECT 
							`key`, 
							`description`, 
							`icon`,
							`icon_hover`,
							`icon_actived` 
					FROM `tbl_lang` 
					WHERE `display` = 1 
					ORDER BY `ordering`';
        $db->query($sql);
        $i = 0;
        if (isset($_SESSION['keyLgArr'])) {
            unset($_SESSION['keyLgArr']);
        }
        if (isset($_SESSION['langArr'])) {
            unset($_SESSION['langArr']);
        }
        while ($row = $db->fetchRow()) {
            $_SESSION['keyLgArr'][$i] = $row->key;
            foreach ($row as $key => $value) {
                $_SESSION['langArr'][$i][$key] = $value;
            }
            $i++;
        }

        if (!isset($_SESSION['lang']) || !in_array($_SESSION['lang'], $_SESSION['keyLgArr'])) {
            if (isset($_SESSION['langArr'][0]['key'])) {
                $_SESSION['lang'] = $_SESSION['langArr'][0]['key'];
            } else {
                $_SESSION['lang'] = LANG_KEY;
            }
        }

        return $_SESSION['lang'];
    }

    //end function
    //create combo box switch language
    public static function CreateComboBoxSwitchLanguage() {
        $s = '<select onchange="javascript:window.location.href=\'language.php?set=\'+this.value;">';

        for ($i = 0; $i < count($_SESSION['langArr']); $i++) {
            $selected = ($_SESSION['lang'] == $_SESSION['langArr'][$i]['key']) ? 'selected="selected"' : '';
            $s .= "<option value='{$_SESSION['langArr'][$i]['key']}' {$selected}>{$_SESSION['langArr'][$i]['description']}</option>";
        }

        $s .= '</select>';

        return $s;
    }

    //create images list switch language
    public static function CreateImagesListSwitchLanguage(&$db) {
        $list = array();

        $db->query("
						SELECT 
								`key` , 
								`description` , 
								CONCAT( 'upload/lang/', `icon` ) AS `image_link` , 
								CONCAT( 'upload/lang/', `icon_hover` ) AS `image_hover` , 
								CONCAT( 'upload/lang/', `icon_actived` ) AS `image_actived`
						FROM `tbl_lang`
						WHERE `display` = 1
						ORDER BY `ordering` 
					");
        if ($db->numRows()) {
            while ($row = $db->fetchRow()) {
                $list[] = $row;
            }
        }

        return $list;
    }

####################################################################################################################################
    /**
     * get language info list
     * for ADMIN ONLY
     * */

    public static function getLangInfoList(&$db, $mode = 'all', $where = 'WHERE `display` = 1') { //mode = all | key | decsription
        if (in_array($mode, array('key', 'description'))) {
            $db->query("SELECT `{$mode}` FROM `tbl_lang` {$where} ORDER BY `ordering`");
            $arr = array();
            while ($row = $db->fetchRow()) {
                $arr[] = $row->{$mode};
            }
            return $arr;
        } else {
            $db->query("SELECT `key`, `description` FROM `tbl_lang` {$where} ORDER BY `ordering`");
            $i = 0;
            while ($row = $db->fetchRow()) {
                $arr['key'][$i] = $row->key;
                $arr['description'][$i] = $row->description;
                $i++;
            }
            return $arr;
        }
    }

    //end function

    /**
     * get language info list
     * for ADMIN ONLY
     * */
    public static function getLangInfoListByKey(&$db, $mode = 'all', $where = 'WHERE `display` = 1') { //mode = all | key | decsription
        $arr = NULL;
        if (in_array($mode, array('key', 'description'))) {
            $db->query("SELECT `{$mode}` FROM `tbl_lang` {$where} ORDER BY `ordering`");
            while ($row = $db->fetchRow()) {
                $arr[$mode] = $row->{$mode};
            }
            return $arr;
        } else {
            $db->query("SELECT `key`, `description` FROM `tbl_lang` {$where} ORDER BY `ordering`");
            $i = 0;
            while ($row = $db->fetchRow()) {
                $arr['key'][$i] = $row->key;
                $arr['description'][$i] = $row->description;
                $i++;
            }
            return $arr;
        }
    }

    //end function

    /**
     * get language config
     * for ADMIN ONLY
     * */
    public static function getLangConfigInfo(&$db, $table) {
        $db->query("SELECT `field` FROM `tbl_config_fields_lang` WHERE `table` = '{$table}'");

        if (!$db->numRows()) {
            return NULL;
        } else {
            $result = array();
            while ($row = $db->fetchRow()) {
                $result[] = $row->field;
            }
            return $result;
        }
    }

    //end function

    /**
     * for ADMIN ONLY
     * */
    public static function createFieldsList($keyLangList = array(), $field = '') {
        $a = array();
        for ($i = 0; $i < count($keyLangList); $i++) {
            $a[] = $field . '_' . $keyLangList[$i];
        }

        return implode(',', $a);
    }

    //end function
}

//end class
?>