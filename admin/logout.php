<?php
// no direct access
if(!defined('IN_SYSTEM')) die(header('Location: ../die.php'));

#global $user;

$user->_logout();

header( "Location: index.php" ); //login OK!!!
exit;


?>