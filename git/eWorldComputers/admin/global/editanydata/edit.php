<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>
<style type="text/css">
<!--
.dfsdfsdfdf {color: #FF0000}
.style1yu {
	font-size: 12px;
	color: #FF0000;
	font-family: Arial, Helvetica, sans-serif;
}
.style1 {
	color: #0000FF;
	font-style: italic;
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
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png" align="middle" border="0" /><br />Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="index.php<?php echo ALV ? '?module=block' : '';?>">
					<img src="../clients/images/cancel.png"  align="middle" border="0" /><br />Cancel</a>
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
   	   <td width="83%" colspan="1" align="left"  valign="bottom" class="content-rows"><input name="display" type="radio" value="1" <?php echo (IO::getPOST('display')) ? 'checked="checked"' : '';?> />
   	     <strong>Enable &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
   	     <input name="display" type="radio" value="0" <?php echo (!IO::getPOST('display')) ? 'checked="checked"' : '';?> />
   	     Disabled</strong></td>
    </tr>

	<tr style="display:<?php echo $displayBlockID;?>;">
      <td height="30" valign="middle" class="content-head" style="padding-left:20px;" >Block ID: </td>
      <td colspan="1" align="left" valign="middle" class="content-rows"><input name="blockid" type="text" id="blockid" value="<?php echo IO::writeData('blockid');?>" size="60" style="height:20px;" /></td>
    </tr>
	<tr>
      <td height="15" colspan="2" align="center" valign="middle" class="content-head"  ><hr /></td>
    </tr>
	
	<?php if ((ALP&&IO::getPOST('ispagesettings'))||(ALP&&!IO::getID()&&!IO::getPOST('ispagesettings'))) :?><input name="ispagesettings" id="ispagesettings" type="hidden" value="<?php echo IO::writeData('ispagesettings');?>" />
	<tr>
	  <td height="30" colspan="2" valign="middle" class="content-head" style="padding-left:20px;" ><strong>Page Settings </strong></td>
    </tr>
	<tr>
	  <td height="30" valign="middle" nowrap="nowrap" class="content-head" style="padding-left:20px;" ><span class="style1">Default URL:</span></td>
	  <td colspan="1" align="left" valign="middle" class="content-rows"><?php if (strlen(IO::getPOST('defaulturl'))):?><input type="text" value="<?php echo IO::writeData('defaulturl');?>" size="100" style="height:20px;" disabled="disabled" /><input name="defaulturl" id="defaulturl" type="hidden" value="<?php echo IO::writeData('defaulturl');?>" /><?php else:?><input name="defaulturl" type="text" id="defaulturl" value="" size="100" style="height:20px;" /><?php endif;?></td>
    </tr>
	<tr>
	  <td height="30" valign="middle" nowrap="nowrap" class="content-head" style="padding-left:20px;" ><span class="style1">Rewriting URL (option): </span></td>
	  <td colspan="1" align="left" valign="middle" class="content-rows"><input name="virtualurl" type="text" id="virtualurl" value="<?php echo IO::writeData('virtualurl');?>" size="100" style="height:20px;" /> <?php ERROR::writeError('virtualurl');?></td>
    </tr>
	<tr>
      <td height="30" valign="middle" nowrap="nowrap" class="content-head" style="padding-left:20px;" ><span class="style1">Page title: </span></td>
      <td colspan="1" align="left" valign="middle" class="content-rows"><input name="pagetitle" type="text" id="pagetitle" value="<?php echo IO::writeData('pagetitle');?>" size="100" style="height:20px;" /></td>
    </tr>
	<tr>
      <td height="30" valign="middle" nowrap="nowrap" class="content-head" style="padding-left:20px;" ><span class="style1">Meta keywords: </span></td>
      <td colspan="1" align="left" valign="middle" class="content-rows"><input name="metakeyword" type="text" id="metakeyword" value="<?php echo IO::writeData('metakeyword');?>" size="100" style="height:20px;" /></td>
    </tr>
	<tr>
      <td height="30" valign="middle" nowrap="nowrap" class="content-head" style="padding-left:20px;" ><span class="style1">Meta descriptions: </span></td>
      <td colspan="1" align="left" valign="middle" class="content-rows"><input name="metadescription" type="text" id="metadescription" value="<?php echo IO::writeData('metadescription');?>" size="100" style="height:20px;" /></td>
    </tr>
	<tr>
      <td height="15" colspan="2" align="center" valign="middle" class="content-head"  ><hr /></td>
    </tr>
	<?php endif;?>
 
 <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
    
    <tr>
      <td class="content-head" style="padding-left:20px;" valign="top" >Content:<br /><span class="dfsdfsdfdf">(<?php echo $this->descriptionLangList[$i];?>)</span></td>
      <td colspan="1" align="left" valign="top" class="content-rows"><?php echo $this->__create_FCK($this->field_DESC[$i], '100%', '600', 
	  IO::getPOST($this->field_DESC[$i]));?></td>
    </tr>
	<tr>
      <td height="15" colspan="2" align="center" valign="middle" class="content-head"  ><hr /></td>
    </tr>
	<?php endfor;?> 
  <tr> <td height="20" >&nbsp;</td><td>&nbsp;</td></tr>   
</table>
</form>