<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>

<!--===================================================================================== -->
<style type="text/css">
<!--
.dsfsdgfsdfgf {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>

<form method="POST" action="" name="form" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><a href="index.php?"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:window.document.form.submit();"><img src="../clients/images/save.png" alt="Lưu" name="save" title="Lưu" align="middle" border="0" /><br />Lưu</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="javascript:window.location.href='<?php echo  $this->__back_url()?>';">
					<img src="../clients/images/cancel.png"  alt="Trở lại" name="cancel" title="Trở lại" align="middle" border="0" /><br />Hủy bỏ</a>
					</td>			
				</tr>
			</table>			
	  </td>
</tr>
</table>
<!--====================================================================================== -->
<table class="adminheading">
	<tr>
		<td>
		<img src="../clients/icons/editor.gif" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;"><p class="content-caption" style="padding-top:15px; padding-left:70px;"><?php echo $this->title;?></p>
		</td>
		<td align="right" valign="top"></td>
		<td align="right" valign="top"></td>
		<td valign="top"></td>
	</tr>		
</table>
<!--====================================================================================== -->
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr height="30">
  	<td colspan="2" background="../clients/images/background.jpg"></td>
  </tr> 
   <tr> <td width="23%" height="20" >&nbsp;</td>
   </tr>
  
 <tr><td height="20" >&nbsp;</td></tr>
 <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
  	<tr>
      <td valign="top" class="content-head" style="padding-left:50px;" >Danh mục (<span class="dsfsdgfsdfgf"><?php echo strtoupper($this->keyLangList[$i]);?></span>):</td>
	  <td width="77%" colspan="1" align="left"  valign="bottom" class="content-rows"><input type="text" size="60" maxlength="50" id="<?php echo $this->field_TEXT[$i];?>" name="<?php echo $this->field_TEXT[$i];?>" value="<?php IO::writeData($this->field_TEXT[$i]);?>" style="height:18px;"/><?php ERROR::writeError($this->field_TEXT[$i], '');?></td>
   </tr>
   <?php endfor;?>
  <tr> <td height="50" >&nbsp;</td></tr>   
</table>
</form>