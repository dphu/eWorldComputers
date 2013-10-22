<?php /* class rewrite url maingocmy2003@yahoo.com 15-apr-2009 9.57 am */if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));


}class __REWRITEURL {

    public static function GetQueryString($a = NULL) {
        if ($a) {
            if (substr($a, strlen($a) - 1, 1) == '/') {
                $a = substr($a, 0, strlen($a) - 1);
            }$a = strtolower($a);
        }global $GLOBALS;
        $b = strtolower($GLOBALS['GLOBALS']['HTTP_SERVER_VARS']['REQUEST_URI']);
        if (substr($b, 0, 1) == '/') {
            $b = substr($b, 1, strlen($b) - 1);
        }if (substr($b, strlen($b) - 1, 1) == '/') {
            $b = substr($b, 0, strlen($b) - 1);
        }if ((strlen($b) > strlen($a)) && (substr($b, 0, strlen($a)) == $a)) {
            $b = substr($b, strlen($a), strlen($b) - strlen($a));
        }if (substr($b, 0, 1) == '/') {
            $b = substr($b, 1, strlen($b) - 1);
        }return($b != $a) ? $b : '';
    }

    public static function GetVirtualPath(&$d, $r) {
        if ($v = __MYMODEL::__doSELECT($d, '*', 'tbl_manualurlsettings', "WHERE `realurl`='{$r}'", NULL, NULL, 'LIMIT 1', 'fetchRow'))
            return BASEURL . INDEX . $v->virtualurl;else
            return BASEURL . INDEX . $r;
    }

    public static function __GetRow(&$d, $m, $i, $debug = FALSE) {
        return __MYMODEL::__doSELECT($d, '*', 'tbl_manualurlsettings', "WHERE(`memberof`='{$m}')AND(`itemid`={$i})", NULL, NULL, 'LIMIT 1', 'fetchRow', $debug);
    }

    public static function __SearchVirtualPath(&$d, $m, $i, $pr, $df) {
        $v = __REWRITEURL::__GetRow($d, $m, $i);
        if (!$v)
            return BASEURL . INDEX . $df;else {
            if ($v->virtualurl)
                return BASEURL . INDEX . $v->virtualurl;else
                return $v->realurl ? BASEURL . INDEX . $v->realurl : BASEURL . INDEX . $df;
        }
    }

    public static function __GetByVirtualURL(&$d, $m, $v, $debug = FALSE) {
        return __MYMODEL::__doSELECT($d, '*', 'tbl_manualurlsettings', "WHERE(`memberof`='{$m}')AND(`virtualurl`='{$v}')", NULL, NULL, 'LIMIT 1', 'fetchRow', $debug);
    }

    public static function __GetByVirtualURLWithoutMember(&$d, $v, $debug = FALSE) {
        return __MYMODEL::__doSELECT($d, '*', 'tbl_manualurlsettings', "WHERE(`virtualurl`='{$v}')", NULL, NULL, 'LIMIT 1', 'fetchRow', $debug);
    }

    public static function __IsDuplicated(&$d, $i, $v) {
        return __MYMODEL::__doSELECT($d, '*', 'tbl_manualurlsettings', "WHERE(`itemid`<>{$i})AND(`virtualurl`='{$v}')", NULL, NULL, 'LIMIT 1', 'fetchRow');
    }

    public static function AutoCheckDuplicateVirtualURL(&$d, $i, $v) {
        if (!strlen($v))
            return FALSE;if (__REWRITEURL::__IsDuplicated($d, $i, $v))
            ERROR::setError('virtualurl', 'Duplicate value');
    }

    public static function GetVirtualURLByMemberAndItemID(&$d, $m, $i, $debug = FALSE) {
        if ($r = __REWRITEURL::__GetRow($d, $m, $i, $debug))
            return($r->virtualurl && strlen($r->virtualurl)) ? BASEURL . INDEX . $r->virtualurl : BASEURL . INDEX . $r->realurl;else
            return'#';
    }

    public static function DeleteURL(&$d, $m, $i, $debug = NULL) {
        return __MYMODEL::__doDELETE($d, 'tbl_manualurlsettings', "WHERE(`memberof`='{$m}')AND(`itemid`={$i})", 'LIMIT 1', $debug);
    }

    public static function GetVirtualURLFromRequest() {
        if (!$v = IO::getKey('virtualurl'))
            return'';else {
            $v = explode('/page/', $v);
            return is_array($v) ? $v[0] : '';
        }
    }

    public static function __GetBasicVirtualURL(&$d, $m, $i, $debug = FALSE) {
        if (!$r = __REWRITEURL::__GetRow($d, $m, $i, $debug))
            return'';else
            return($r->virtualurl && strlen($r->virtualurl)) ? $r->virtualurl : '';
    }

}

?>