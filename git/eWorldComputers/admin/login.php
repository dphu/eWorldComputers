<?php
$postback = isset( $_POST['postback'] ) ? true : false;
error_reporting(false);
session_start();
require( "../libs/db.php" );
require_once( "../config/db.php" );
require( "../libs/user.class.php" );
//if ($postback)
if($_SERVER['REQUEST_METHOD']=="POST")
{

	$username = $_POST['admin_name'];
	$password = $_POST['password'];
	$remember = FALSE; // Remember login checkbox
		
	$db = new DB(USER, PASS, DBNAME, HOST);	
	$user = new user( $db );
	$kt = $user->_checkLogin( $username, $password, $remember );
	if(!$kt) {
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<script language='javascript' type='text/javascript'>alert('Invalid username or password');window.location='index.php';</script>";	
	
	}	
}

if (isset( $_SESSION['logged'] ) && $_SESSION['logged'] ) {
	header( "Location: index.php" );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator Area :: Login page</title>
<link rel="stylesheet" type="text/css" href="../clients/css/admin.css">
</head>

<body bgcolor="#006699">
<center>
<div align="center" style="width:800px;background-color:#FFFFFF">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<table width="100%" border="0" cellspacing="8" cellpadding="0">
		  <tr>
			<td height="*" align="center" valign="middle">&nbsp;</td>
			<td width="79%" align="center" class="top_title1">CONTENT MANAGEMENT SYSTEM</td>
		  </tr>
		</table>	
	</td>
  </tr>
  <tr>
    <td height="32" class="header_box" align="left">
	Today: <?php echo gmdate("d-m-Y",time());?>	</td>
	<td height="32" class="header_box"  align="right">&nbsp;</td>
  </tr>  
  <tr>
    <td height="35" align="center" valign="middle" class="login_title">Please input username and password to login</td>
  </tr>
</table>
	<form action="" onsubmit="return check_submit()" method="post" name="login" style="margin:0">
	
		<table width="300" border="0" cellspacing="0" cellpadding="2">
		  <tr>
			<td height="27" align="left" class="leftmenu_title"><b>Username<b></td>
			<td align="left"><input name="admin_name" type="text" id="admin_name" maxlength="50" class="text_view_1" style="width:180px;"></td>
		  </tr>
		  <tr>
			<td class="leftmenu_title" align="left"><b>Password<b></td>
			<td align="left"><input name="password" type="password" id="password" size="28" maxlength="50" class="text_view_1" style="width:180px;"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td align="left" valign="bottom" height="40">
				<input type="submit" name="Submit" value="Login" class="text_view_1">
				<input type="reset" name="Submit2" value="Reset" onClick="javascript: set_focus();" class="text_view_1">
			</td>
		  </tr>
	  </table>
<input name="postback" type="hidden" value="true" />	
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="27">&nbsp;</td>
 </tr>

  <tr>
    <td>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bottom_bar">
				<tr>
					<td height="30" align="left" valign="middle" bgcolor="#000000" class="top_copyright">EworldComputer.com</td>
				</tr>
	</table>
</div>
</center>
</body>
</html>
<script language="javascript" type="text/javascript">
document.forms['login'].admin_name.focus();
function set_focus(){
document.forms['login'].admin_name.focus();
}
function check_submit()
{
	var frm = window.document.login; 		
	if (frm.admin_name.value=='')
		{
			alert('Please input username');			
			document.forms['login'].admin_name.focus();
			return false;
		}
	else if (frm.password.value=='')
		{
			alert('Please input password');
			document.forms['login'].password.focus();			
			return false;
		}		
	else						
		return true;
}

</script>


