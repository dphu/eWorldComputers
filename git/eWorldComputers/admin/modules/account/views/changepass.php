<?php 
	defined('IN_SYSTEM') or die('<hr>');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') //submit
	{
		$id = $_POST['uid'];
		
		$old_admin_name=isset($_POST['old_admin_name'])? ($_POST['old_admin_name']):'';
		$old_password=isset($_POST['old_password'])? ($_POST['old_password']):'';
		#check old info
		if (!isset($_SESSION['username']) || (($old_admin_name) != $_SESSION['username']) || !isset($_SESSION['password']) || (md5($old_password) != $_SESSION['password']) || !isset($_SESSION['logged']) || !$_SESSION['logged']) {
			die("Invalid current account infomation.");
		}
		
		$new_admin_name=isset($_POST['admin_name'])? ($_POST['admin_name']):'';
		$new_password_1=isset($_POST['new_password_1'])? ($_POST['new_password_1']):'';
		$new_password_2=isset($_POST['new_password_2'])? ($_POST['new_password_2']):'';
		
		//kT new admin name
		if (strlen(trim($new_admin_name)) < 6) {
			die("Username must contrains 6 letters or more");
		}
		
		//kiem tra 2 new pass
		if(!strlen($new_password_1) || !strlen($new_password_2)){
			die("New password invalid");
		}
		if($new_password_1!=$new_password_2){
			die("The new and the confirm passwords does not match");
		}
		if(strlen($new_password_1)<6){
			die("New password must contrains 6 letters or more");
		}
		
		//KT id
		if(intval($id) == 0){
			die("Invalid!");
		}

		//change
		$sql="UPDATE `tbl_admin` SET `admin_name`='".(($new_admin_name))."', password='".md5(($new_password_1))."' WHERE id=".$id; 					
		$this->_db->query($sql);
		
		session_destroy();
		echo '<script language="javascript" type="text/javascript">window.location.href="index.php";</script>';
		die('Account changed');
	}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.admin_change_pass {
	font-size: 16px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	color: #003399;
}
-->
</style>
</head>
<body>
<img src="../clients/icons/editor.gif" style="float: left; margin-right: 10px;">
<p class="content-caption">Change account (allow change Username and Password)</p>
<p class="content-rows"><a href="?">Administrator</a> &raquo; Change account </p>
<hr style="clear: both;" />

	<form action="" method="post" name="form1" id="form1" >
	<div align="center">
		<table width="300" border="0" cellspacing="0" cellpadding="2">
		  <tr>
            <td nowrap class="content-head"><div align="right">Current username: </div></td>
		    <td class="content-rows"><input name="old_admin_name" type="text" id="old_admin_name" value="" maxlength="70" class="form-field" style="width:170px;"></td>
	      </tr>
		  <tr>
            <td nowrap  class="content-head"><div align="right">Current password: </div></td>
		    <td class="content-rows"><input name="old_password" type="password" id="old_password" maxlength="70" class="form-field" style="width:170px;"></td>
	      </tr>
		  <tr>
		    <td nowrap class="content-head">&nbsp;</td>
		    <td class="content-rows">&nbsp;</td>
	      </tr>
		  <tr>
			<td nowrap class="content-head"><div align="right">New username: </div></td>
			<td class="content-rows"><input name="admin_name" type="text" id="admin_name" value="" maxlength="70" class="form-field" style="width:170px;"></td>
		  </tr>
		  <tr>
			<td nowrap  class="content-head"><div align="right">New password: </div></td>
			<td class="content-rows"><input name="new_password_1" type="password" id="new_password_1" maxlength="70" class="form-field" style="width:170px;"></td>
		  </tr>
		  <tr>
			<td nowrap  class="content-head"><div align="right">Confirm new password: </div></td>
			<td class="content-rows"><input name="new_password_2" type="password" id="new_password_2" maxlength="70" class="form-field" style="width:170px;"></td>
		  </tr>		  
		  <tr>
			<td class="content-head">&nbsp;</td>
			<td class="content-rows"><input type="submit" name="Submit" value="Submit" class="form-field">
		    <input type="reset" name="Submit2" value="Reset" class="form-field"></td>
		  </tr>
	  </table>

	</div>
<input name="postback" type="hidden" value="true" />	
<input name="uid" type="hidden" value="<?php echo $this->_data->id?>" />	
</form>
</body>
</html>