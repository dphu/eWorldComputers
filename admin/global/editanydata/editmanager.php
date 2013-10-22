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
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png" align="middle" border="0" /><br />
					Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="index.php">
					<img src="../clients/images/cancel.png"  align="middle" border="0" /><br />
					Cancel</a>
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
    <tr>
      <td colspan="2" valign="top" nowrap="nowrap" class="content-head" style="padding-left:5px;"><?php echo FCK ? $this->__create_FCK('content', '100%', '500', $row->content) : "<textarea name=\"content\" style=\"width:100%; height:500px;\">{$row->content}</textarea>";?></td>
    </tr>
  <tr> <td height="20" >&nbsp;</td><td width="83%">&nbsp;</td></tr>   
</table>
</form>