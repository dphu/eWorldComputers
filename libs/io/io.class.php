<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

class IO {

    private static function __requiredStripSlashesWhileFDKGetPOST() {
        $a = true;
        return $a;
    }

    /**
      auto get POST value from submited form
     * @param: id, default value
     * @access: private
     * @return: post value
     * */
    public static function getPOST($id, $default = '', $forFCK = false, $type = 'any') {
        if (!isset($_POST[$id])) {
            return $default;
        } elseif ($type == 'password') {
            return $_POST[$id];
        } else {
            $s = str_replace('src="' . MYSITEROOT . 'attachment/', 'src="attachment/', $_POST[$id]);
            if ($forFCK) {
                $a = array("\\\"&quot;", "&quot;\\\"");
                $b = "\\\"";
                while ((FALSE !== strpos($s, $a[0])) || (FALSE !== strpos($s, $a[1]))) {
                    $s = str_replace($a, $b, $s);
                }
            }
            return $s;
        }
    }

    //end function

    /**
      auto set POST value
     * @param: id, value
     * @access: public
     * @return: void
     * */
    public static function setPOST($id, $value = '') {
        $_POST[$id] = IO::formatOutput($value);
    }

    //end function
    //format input
    public static function formatInput($input) {
        /* if (get_magic_quotes_gpc()) {
          return $input;
          } */

        if (is_array($input)) {
            foreach ($input as $key => $val) {
                $input[$key] = IO::formatInput($val);
            }
            return $input;
        } else {
            $input = stripslashes($input);
            return addslashes($input);
        }
    }

    //end function
    //format output
    public static function formatOutput($output) {
        if (is_array($output)) {
            foreach ($output as $key => $val) {
                $output[$key] = IO::formatOutput($val);
            }
            return $output;
        } else {
            //*$output = stripslashes($output);*/
            /* $output = str_replace( '"', '&#'.ord('"').';', $output);
              $output = str_replace( "'", "&#".ord("'").";", $output); */
            //return $output;
            return stripslashes($output);
        }
    }

    //end function

    /**
     * write data to form object
     * @param: id
     * @access: private
     * @return: void
     * */
    public static function writeData($id, $default = '') {
        if (isset($_POST[$id])) {
            echo trim(IO::formatOutput($_POST[$id]));
        } else {
            echo $default;
        }
    }

    //end function	

    /**
     * auto get request key
     * */
    public static function getKey($key, $default_value = '') {
        return isset($_GET[$key]) ? $_GET[$key] : $default_value;
    }

    //end function

    /**
     * auto get request id (number)
     * */
    public static function getID($key = 'id') {
        if ($key == '') {
            $key = 'id';
        }

        return abs(intval(IO::getKey($key, '0')));
    }

    //end function

    private static function PRI_CheckSecurity($key, $diemsg = '') {
        if (isset($_GET[$key])) {
            $s = strtolower($_GET[$key]);
            if (strlen($s) > 1) {
                if (substr($s, 0, 1) == '_') {
                    if ($diemsg != '') {
                        die($diemsg);
                        return false;
                    } else {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public static function checkSecurity($key = '', $diemsg = 'Access Denied!') {
        if ($key != '') {
            return IO::PRI_CheckSecurity($key, $diemsg);
        } elseif (isset($_GET) && count($_GET)) {
            foreach ($_GET as $key => $value) {
                if (!IO::PRI_CheckSecurity($key, $diemsg)) {
                    return false;
                }
            }
        }

        return true;
    }

    #redirect

    public static function redirect($page) {
        echo "<script type='text/javascript'>document.location.href='{$page}'</script>";
    }

    public static function autoRefresh() {
        return IO::refresh(IO::getBackURL());
    }

    public static function getBackURL() {
        return isset($_SESSION['current_link']) ? $_SESSION['current_link'] : 'index.php';
    }

    public static function setBackURL($index_file = 'index.php') {
        $_SESSION['current_link'] = $index_file . '?' . @$_SERVER['QUERY_STRING'];
    }

    public static function refresh($default_page = 'index.php?') {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = $default_page;
        }

        return IO::redirect($url);
    }

    public static function popup($url, $name = '', $w = 450, $h = 450) {
        return "window.open('{$url}', '{$name}', 'toolbars=no, resizeable=no, menus=no, width={$w}, height={$h}, scrollbars=yes');";
    }

    //xuat du ra browser
    public static function writeBlock($divId, $content = '') {
        $sid = str_replace(' ', '', microtime());
        $sid = str_replace('.', '', $sid);

        $_SESSION[$sid] = $content;

        return "<script language=\"javascript\" type=\"text/javascript\">getBlockEx('{$divId}', '{$sid}');</script>";
    }

    //sau khi cac module doc du lieu, thi su dung ham nay de show ra browser...
    public static function writeBlockEx($divId, $content = '') {
        $content = removeFirstPTag(addslashes(str_replace(chr(13), '', str_replace(chr(10), '', $content))));

        return "<div style=\"display:none;\"><script language=\"javascript\" type=\"text/javascript\">document.getElementById('{$divId}').innerHTML='{$content}';</script></div>";
    }

}

//end class
?>