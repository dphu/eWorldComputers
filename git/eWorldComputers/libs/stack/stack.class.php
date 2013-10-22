<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

class STACK {

    private $__STACK__ = '';

    public function __construct($prefix = '') {
        $this->__STACK__ = md5(session_id() . $prefix);
    }

    //emty STACK
    private function clear() {
        if (isset($_SESSION[$this->__STACK__])) {
            unset($_SESSION[$this->__STACK__]);
        }
    }

    //is empty
    private function isEmpty() {
        return (!isset($_SESSION[$this->__STACK__]) || !is_array($_SESSION[$this->__STACK__]) || !count($_SESSION[$this->__STACK__])) ? TRUE : FALSE;
    }

    //create
    private function create() {
        if ($this->isEmpty()) {
            $_SESSION[$this->__STACK__] = array();
        }
    }

    public function push($value) {
        $this->create();
        $_SESSION[$this->__STACK__][count($_SESSION[$this->__STACK__])] = $value;
    }

    public function pop() {
        if ($this->isEmpty()) {
            return NULL;
        } else {
            $value = $_SESSION[$this->__STACK__][count($_SESSION[$this->__STACK__]) - 1];
            if (count($_SESSION[$this->__STACK__]) <= 1) {
                $this->clear();
            } else {
                unset($_SESSION[$this->__STACK__][count($_SESSION[$this->__STACK__]) - 1]);
            }
            return $value;
        }
    }

}

//end class
?>