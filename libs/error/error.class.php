<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

/**
 * MY~
 * class tu dong set, check, display cac loi trong khi submit data tren form
 * */
class ERROR {

    //contructor
    public function __construct() {
        //null
    }

    //destructor
    public function __destruct() {
        //null
    }

    /**
     * clear al error
     * @param: none
     * @access: public
     * @return: void
     * */
    public static function clearAllError() {
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
    }

    //end function	

    /**
     * write Error to form
     * @param: id
     * @access: public
     * @return: void
     * */
    public static function writeError($id, $default = '') {
        $result = ERROR::__getError($id);
        if ($result != '') {
            echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FF0000;">&nbsp;' . $result . '</span>';
        } else {
            echo '<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FF0000;">&nbsp;' . $default . '</span>';
        }
    }

    //end function

    /**
     * get error
     * @param: id
     * @access: public
     * @return: void
     * */
    public static function getError($id) {
        return ERROR::__getError($id);
    }

    //end function
    /**
     * get error
     * @param: id
     * @access: protected
     * @return: string
     * */
    protected static function __getError($id) {
        if (isset($_SESSION['error'][$id]) && $_SESSION['error'][$id] != '') {
            return $_SESSION['error'][$id];
        } else {
            return '';
        }
    }

    //end function

    /**
     * set error
     * @param: id, err message
     * @access: public
     * @return: void
     * */
    public static function setError($id, $msg = '') {
        if ($msg !== NULL) {
            $_SESSION['error'][$id] = $msg;
        } else {
            ERROR::clearError($id);
        }
    }

    //end function

    public static function clearError($id) {
        if (isset($_SESSION['error'][$id])) {
            unset($_SESSION['error'][$id]);
        }
    }

    /**
     * is error ?
     * @param: none
     * @access: public
     * @return: true/false
     * */
    public static function isError() {
        return (!isset($_SESSION['error']) || !count($_SESSION['error']) || !is_array($_SESSION['error'])) ? false : true;
    }

    //end function

    /* show message box */
    public static function msgBox($msg) {
        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script type='text/javascript'>alert('{$msg}');</script>";
    }

}

//end class
?>