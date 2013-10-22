<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>
<style type="text/css">
<!--
.dfsdfsdfdf {color: #FF0000}
.style1yu {
	font-size: 12px;
	color: #FF0000;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>

<form method="POST" action="" name="form" id="form" style="margin:0" enctype="multipart/form-data">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="40%" nowrap="nowrap" class="menudottedline">		
	  <div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div>
	</td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png" alt="Lưu" name="save" title="Lưu" align="middle" border="0" /><br />Lưu</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="index.php">
					<img src="../clients/images/cancel.png"  alt="Trở lại" name="cancel" title="Trở lại" align="middle" border="0" /><br />Hủy bỏ</a>
					</td>			
				</tr>
			</table>			
	  </td>
</tr>
</table>
<table class="adminheading">
	<tr>
		<td nowrap="nowrap">
		<img src="../clients/icons/editor.gif" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;">
		<p class="content-caption" style="padding-top:15px; padding-left:70px;"><?php echo $this->title;?></p>
	  </td>
		<td align="right" valign="top"></td>
		<td align="right" valign="top"></td>
		<td valign="top"></td>
	</tr>		
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr height="30">
  	<td colspan="2" background="../clients/images/background.jpg"></td>
  </tr> 
   <tr> <td width="17%" height="20" >&nbsp;</td>
   </tr>
  
 <tr> <td height="20" >&nbsp;</td></tr>
 <tr>
   	   <td valign="top"  class="content-head" style="padding-left:20px;" >Status:</td>
   	   <td width="83%" colspan="1" align="left"  valign="bottom" class="content-rows"><input name="display" type="radio" value="1" <?php echo ($row->display) ? 'checked="checked"' : '';?> />
   	     <strong>Enable &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
   	     <input name="display" type="radio" value="0" <?php echo (!$row->display) ? 'checked="checked"' : '';?> />
   	     Disabled</strong></td>
    </tr>
 <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
   <tr> <td height="28" >&nbsp;</td>
   <td><em><span class="style1yu">(chiều rộng tối đa của khu vực này là <?php echo 
MAX_WIDTH;?> pixel)</span></em></td>
   </tr>
    <tr>
      <td class="content-head" style="padding-left:20px;" valign="top" >Nội dung :<br /><span class="dfsdfsdfdf">(<?php echo $this->descriptionLangList[$i];?>)</span></td>
      <td class="content-rows" align="left" colspan="1"><?php echo $this->__create_FCK($this->field_DESC[$i], '100%', '350', 
	  $row->{$this->field_DESC[$i]});?></td>
    </tr>
	<tr>
      <td height="15" colspan="2" align="center" valign="middle" class="content-head" style="padding-left:20px;" ><hr /></td>
    </tr>
	<?php endfor;?> 
  <tr> <td height="20" >&nbsp;</td><td>&nbsp;</td></tr>   
</table>
</form>