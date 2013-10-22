<?php

if (!defined('IN_SYSTEM'))
    die(header('Location: ../die.php'));

function view(&$obj, $decodeHTML = FALSE, $die = TRUE) {
    echo '<pre>';
    if ($decodeHTML)
        var_dump(htmlentities($obj));
    else
        var_dump($obj);
    echo '</pre>';
    if ($die)
        die;
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('" . $msg . "')</script>";
}

function breakLine($s, $br = true) {
    return $br ? str_replace(chr(13), '<br />', $s) : str_replace(chr(13), ' ', str_replace(chr(10), '<br />', $s));
}

//create combo box switch language
function __createComboBoxSwitchLanguage($css = '') {
    $s = '<select id="language" onchange="javascript:window.location.href=\'language.php?set=\'+this.value;" ' . $css . '>';

    for ($i = 0; $i < count($_SESSION['langArr']); $i++) {
        $selected = ($_SESSION['lang'] == $_SESSION['langArr'][$i]['key']) ? 'selected="selected"' : '';
        $s .= "<option value='{$_SESSION['langArr'][$i]['key']}' {$selected}>{$_SESSION['langArr'][$i]['description']}</option>";
    }

    $s .= '</select>';

    return $s;
}

//create link switch language
function __createLinkSwitchLanguage($class) {
    $s = array();

    for ($i = 0; $i < count($_SESSION['langArr']); $i++) {
        $s[] = ($_SESSION['langArr'][$i]['key'] != $_SESSION['lang']) ? ("<a href=\"language.php?set={$_SESSION['langArr'][$i]['key']}\" class=\"{$class}\">{$_SESSION['langArr'][$i]['description']}</a>") : "{$_SESSION['langArr'][$i]['description']}";
    }

    return implode(' | ', $s);
}

//create images list switch language
function __createImagesListSwitchLanguage(&$db) {
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

//remove tag <P></P> on FCK
function removeFirstPTag($content) {
    //<p>
    if (strtolower(substr($content, 0, 3)) == '<p>') {
        $content = substr($content, 3);
    }

    //</p>
    if (strtolower(substr($content, strlen($content) - 4)) == '</p>') {
        $content = substr($content, 0, strlen($content) - 4);
    }

    return $content;
}

//is flash ?
function __isFlash($f) {
    $a = @explode('.', $f);
    if (is_array($a)) {
        if (count($a) > 1) {
            if (strtolower($a[count($a) - 1]) == 'swf') {
                return true;
            }
        }
    }

    return false;
}

//show flash (folder, w|h|file)
function __showFlash($folder, $fileStruct) {
    $a = explode('|', $fileStruct);
    $width = $a[0];
    $height = $a[1];
    $file = $a[2];
    $mainFile = substr($file, 0, strlen($file) - 4);

    $s = "<script type=\"text/javascript\" language=\"javascript\">AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','{$width}','height','{$height}','src','{$folder}{$mainFile}','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','{$folder}{$mainFile}' );</script><noscript><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0\" width=\"{$width}\" height=\"{$height}\"><param name=\"wmode\" value=\"transparent\" /><param name=\"movie\" value=\"{$folder}{$file}\" /><param name=\"quality\" value=\"high\" /><embed src=\"{$folder}{$file}\" quality=\"high\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"{$width}\" height=\"{$height}\"></embed></object></noscript>";

    return $s;
}

function makeFolder($folder) {
    if (@mkdir($folder)) {
        @chmod($folder, 0777);
    }
}

function makeTreeFolder($tree) { //tao cay thu muc
    $folder = '';
    $arr = @explode('/', $tree);
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] != '..') {
            $folder = $folder . '/' . $arr[$i];
            makeFolder('../' . $folder);
        }
    }
}

///////////////////////
//from dd-mm-yyyy to unixtimestamp
function __mkTime($s) {
    if ($s == '') {
        return 0;
    }

    $a = @explode('-', $s);
    if (!is_array($a) || count($a) != 3) {
        return 0;
    }

    return mktime(intval(date('G', time())), intval(date('i', time())), intval(date('s', time())), $a[1], $a[0], $a[2]);
}

//from unixtimestamp to d-m-Y h:i a 
function __getTime($t, $fullTime = false) {
    $fullTime = $fullTime ? ' h:i a' : '';
    return $t ? date('d-m-Y' . $fullTime, $t) : NULL;
}

//templates
function __getTemplate($prefix, $fd = 'templates/') {
    $_SESSION[session_id() . 'template'] = @file_get_contents($fd . $prefix . '.tpl');
}

function __getTemplateDB(&$db, $templateID = '') {//dc set tu admin
    $_SESSION[session_id() . 'template'] = loadBlock($db, $templateID);
}

function __reGetTemplate(&$fromObject) {
    $_SESSION[session_id() . 'template'] = $fromObject;
}

function __setTemplate($tag, $value, $absolute = false) {
    if (isset($_SESSION[session_id() . 'template'])) {
        $tag = !$absolute ? "{{$tag}}" : $tag;
        $_SESSION[session_id() . 'template'] = str_replace($tag, $value, $_SESSION[session_id() . 'template']);
    }
}

function __setTemplateList($array, $absolute = false) {
    if (is_array($array)) {
        foreach ($array as $k => $v) {
            __setTemplate($v[0], $v[1], $absolute);
        }
    }
}

function __outTemplate(&$toObject = NULL) {
    if (!isset($toObject)) {
        if (isset($_SESSION[session_id() . 'template'])) {
            echo $_SESSION[session_id() . 'template'];
            unset($_SESSION[session_id() . 'template']);
        }
    } else {
        if (isset($_SESSION[session_id() . 'template'])) {
            $toObject = $_SESSION[session_id() . 'template'];
            unset($_SESSION[session_id() . 'template']);
        } else {
            $toObject = NULL;
        }
    }
}

//DB
//get cat text
function __getCatText(&$db, $table, $id, $lang = NULL) {
    if (!$lang) {
        $lang = $_SESSION['lang'];
    }
    return ($r = __MYMODEL::__doSELECT($db, '*', $table, "WHERE `id` = {$id}", NULL, NULL, 'LIMIT 1', 'fetchRow')) ? $r->{"name_{$lang}"} : '&nbsp;';
}

function getVirtualURLBlock(&$db, $blockID) {
    if ($row = __MYMODEL::__doSELECT($db, '`virtualurl`', 'tbl_interface_manager', "WHERE (`blockid` = '{$blockID}') AND (`display` = 1)", NULL, NULL, 'LIMIT 1', 'fetchRow')) {
        return $row->virtualurl;
    } else {
        return '';
    }
}

function getDefaultURLBlock(&$db, $id) {
    if ($row = __MYMODEL::__doSELECT($db, '`defaulturl`', 'tbl_interface_manager', "WHERE `id` = {$id}", NULL, NULL, 'LIMIT 1', 'fetchRow')) {
        return $row->defaulturl;
    } else {
        return '';
    }
}

//load lock
function loadBlock(&$db, $blockID = '') {
    if (
            isset($_SESSION['contact-done']) &&
            is_array($_SESSION['contact-done']) &&
            isset($_SESSION['contact-done']['key']) &&
            isset($_SESSION['contact-done']['value']) &&
            $_SESSION['contact-done']['key'] == $blockID
    ) {
        $msg = $_SESSION['contact-done']['value'];
        unset($_SESSION['contact-done']);
    } else {
        $msg = '';
    }

    return $msg . removeFirstPTag(__LOAD_ANY_DATA_CLASS::GETDATAINTERFACE($db, $blockID));
}

//create cac loai combobox
function __createComBoBox(&$db, $cbname, $table, $where, $key, $lang = NULL, $event = NULL, $css = NULL) {
    $lang = $lang ? $lang : 'vn';
    $field = "name_{$lang}";
    $s = "<select name=\"{$cbname}\" id=\"{$cbname}\" {$event} style=\"{$css}\">";
    $s .= '<option selected="selected" value="">&nbsp;&nbsp;&nbsp;--- Chọn ---&nbsp;&nbsp;&nbsp;&nbsp;</option>';

    if ($rows = __MYMODEL::__doSELECT($db, '*', $table, $where, NULL, "ORDER BY `ordering`", NULL, 'fetchRowSet')) {
        foreach ($rows as $k => $v) {
            $selected = ($v->id == $key) ? 'selected = "selected"' : '';
            $s .= "<option value=\"{$v->id}\" {$selected}>&nbsp;&nbsp;&nbsp;{$v->{$field}}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
        }
    }

    $s .= '</select>';

    return $s;
}

//get prefix time...
function __getPrefix() {
    $prefix = microtime();
    return str_replace('.', '', str_replace(' ', '', $prefix));
}

//show number as image
function showNumAsImage($number, $folder) {
    $s = strval($number);
    $content = '<span>';
    for ($i = 0; $i < strlen($s); $i++) {
        $digi = substr($s, $i, 1);
        $content .= "<img src=\"{$folder}{$digi}\" border=\"0\" />";
    }
    $content .= '</span>';
    return $content;
}

//change title
function __getDefaultTitle(&$db) {
    $row = __MYMODEL::__doSELECT($db, '*', 'tbl_config', "WHERE `config_name`='title'", '', '', 'LIMIT 1', 'fetchRow');

    return $row ? $row->config_value : 'Welcome to our Website...';
}

function __setNewTitle($s = '') {
    $_SESSION[session_id()]['__pageTitle__'] = $s;
}

function __appendNewTitle(&$db, $s = '') {
    $oldTitle = __getNewTitle($db);
    $_SESSION[session_id()]['__pageTitle__'] = $s . ', ' . $oldTitle;
}

function __getNewTitle(&$db) {
    return $_SESSION[session_id()]['__pageTitle__'] ? $_SESSION[session_id()]['__pageTitle__'] : __getDefaultTitle($db);
}

// form for news content
function __autoGetFormListForConfigNews(&$db) {
    if (NULL === ($rows = __MYMODEL::__doSELECT($db, "`blockid` AS `keyname`, `desc_{$_SESSION['lang']}` AS `value`", 'tbl_interface_manager', "WHERE `blockid` LIKE ('FORM::form-%')
AND (`display` = 1)", NULL, NULL, NULL, 'fetchRowSet')))
        return NULL;

    $list = array();
    foreach ($rows as $index => $row)
        $list[] = array('key' => $row->keyname, 'value' => $row->value);

    return $list;
}

function __putFormsIntoNewsContent(&$formList) {
    global $content;

    if (is_array($formList) && count($formList))
        foreach ($formList as $index0 => $item)
            foreach ($item as $index1 => $key)
                $content = str_replace("{{$key}}", $item['value'], $content);

    if (isset($_SESSION["contact-done"])) {
        $content = str_replace('<div id="form-contact-done">&nbsp;</div>', '<div id="form-contact-done">' . $_SESSION["contact-done"] . '</div>', $content);
        unset($_SESSION["contact-done"]);
    }
}

//end of form for news content

function GetAlternativeTextControl($size = '30', $table = NULL, $key = NULL, $label = NULL) {
    if (($table == '') && !defined('TABLE_NAME')) {
        return 'Error: table name is not valid!';
    }

    if ($table === NULL) {
        $table = TABLE_NAME;
    }

    if ($key === NULL) {
        $key = 'alt';
    }

    global $db;
    $db->query("ALTER TABLE {$table} ADD `{$key}` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL");

    return '<label>' . $label . '<input name="' . $key . '" id="' . $key . '" type="text" size="' . $size . '" value="' . IO::getPOST($key) . '" /></label>';
}

//SMN admin
function SMN() {
    if ((isset($_GET['thuanan']) && ($_GET['thuanan'] == 'thuanan')) || (isset($_SESSION['thuananSMN']))) {
        $_SESSION['thuananSMN'] = true;
        echo "
		[null,'[Administrator]','index.php',null,'',
				['','Cấu hình Site','index.php?module=config',null,'Cấu hình Site'],
				
				['','Cấu hình ngôn Ngữ ' + b('►'),null,null,'',
					['','Danh mục ngôn ngữ','index.php?module=langconfig',null,''],
					['','Thùng rác (Trash)','index.php?module=langconfig&function=recyclebin',null,''],
					['','Tự động tạo Database','index.php?module=langconfig&function=autoupdate',null,''],
				],
			],
			
			[null,'[Giao diện]',null,null,'',
				['','Block Manager','index.php?module=block',null,''],
				['','Block ID Manager','index.php?module=blockid_manager',null,''],
				_cmSplit,
				['','Template Manager','index.php?module=template_manager',null,''],
				['','CSS Manager','index.php?module=css_manager',null,''],
				['','Image MAP Manager','index.php?module=map_manager',null,''],
				['','AJAX Manager','index.php?module=ajax_manager',null,''],
				_cmSplit,
				['',b('Site Title Manager'),'index.php?module=sitetitle_manager',null,''],
				_cmSplit,
				['',b('Admin Editor Design'),'index.php?module=admineditordesign_manager',null,''],
			],
			";
    }
}

?>