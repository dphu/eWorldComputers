<?php

// $Id: strpbrk.php,v 1.7 2007/04/17 10:09:56 arpad Exp $

/**
 * Replace strpbrk()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @license     LGPL - http://www.gnu.org/licenses/lgpl.html
 * @copyright   2004-2007 Aidan Lister <aidan@php.net>, Arpad Ray <arpad@php.net>
 * @link        http://php.net/function.strpbrk
 * @author      Stephan Schmidt <schst@php.net>
 * @version     $Revision: 1.7 $
 * @since       PHP 5
 * @require     PHP 4.0.0 (user_error)
 */
function php_compat_strpbrk($haySTACK, $char_list) {
    if (!is_scalar($haySTACK)) {
        user_error('strpbrk() expects parameter 1 to be string, ' .
                gettype($haySTACK) . ' given', E_USER_WARNING);
        return false;
    }

    if (!is_scalar($char_list)) {
        user_error('strpbrk() expects parameter 2 to be string, ' .
                gettype($char_list) . ' given', E_USER_WARNING);
        return false;
    }

    $haySTACK = (string) $haySTACK;
    $char_list = (string) $char_list;

    $len = strlen($haySTACK);
    for ($i = 0; $i < $len; $i++) {
        $char = substr($haySTACK, $i, 1);
        if (strpos($char_list, $char) === false) {
            continue;
        }
        return substr($haySTACK, $i);
    }

    return false;
}

// Define
if (!function_exists('strpbrk')) {

    function strpbrk($haySTACK, $char_list) {
        return php_compat_strpbrk($haySTACK, $char_list);
    }

}
