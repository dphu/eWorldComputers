<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>

<!-- ===================================================================================== -->

<form method="POST" action="" name="form" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><a href="index.php?"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:window.document.form.submit();"><img src="../clients/images/save.png" align="middle" border="0" /><br />
					Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="javascript:window.location.href='<?php echo  $this->__back_url()?>';">
					<img src="../clients/images/cancel.png"  align="middle" border="0" /><br />
					Cancel</a>
					</td>			
				</tr>
			</table>			
	  </td>
</tr>
</table>
<!-- ====================================================================================== -->
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
<!-- ====================================================================================== -->
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr height="30">
  	<td colspan="2" background="../clients/images/background.jpg"></td>
  </tr> 
   <tr> <td width="23%" height="20" >&nbsp;</td>
   </tr>
  
 <tr> <td height="20" >&nbsp;</td></tr><tr>
  	  <td height="19" valign="top"  class="content-head" style="padding-left:50px;" ><?php echo TITLE_FILTER_INSERT;?></td>
  	  <td colspan="1" align="left"  valign="top" class="content-rows"><?php echo $combobox;?><?php ERROR::writeError('menu_id', '');?></td>
    </tr>
	<tr>
      <td valign="top" nowrap="nowrap"  class="content-head" style="padding-left:50px;" >Code:</td>
	  <td width="77%" colspan="1" align="left"  valign="bottom" class="content-rows"><input type="text" size="30" id="code" name="code" value="<?php IO::writeData('code');?>" style="height:18px;"/><?php ERROR::writeError('code', '*');?></td>
   </tr>
 <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
   	<tr>
      <td valign="top" nowrap="nowrap"  class="content-head" style="padding-left:50px;" >Name (<font color="#FF0000"><?php echo $this->keyLangList[$i];?></font>):</td>
	  <td width="77%" colspan="1" align="left"  valign="bottom" class="content-rows"><input type="text" size="30" id="<?php echo $this->field_NAME[$i];?>" name="<?php echo $this->field_NAME[$i];?>" value="<?php IO::writeData($this->field_NAME[$i]);?>" style="height:18px;"/><?php ERROR::writeError($this->field_NAME[$i], '*');?></td>
   </tr>
   <?php endfor;?>
  <tr> <td height="50" >&nbsp;</td></tr>   
</table>
</form>