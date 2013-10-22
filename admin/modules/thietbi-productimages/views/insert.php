<?php 
defined('IN_SYSTEM') or die('<hr>');
?>
<!-- ===================================================================================== -->
<style type="text/css">
<!--
.gyy {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: italic;
	color: #0066FF;
	font-weight: normal;
}
.ttttttttttttttt {font-family: tahoma}
.asasgffgfdg {	color: #0000CC;
	font-style: italic;
	font-weight:normal;
	text-decoration:underline;
}
-->
</style>
<form action="" method="post" enctype="multipart/form-data" name="fff" id="fff" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><a href="../views/index.php"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:dosubmit('fff');"><img src="../clients/images/save.png" align="middle" border="0" /><br />Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="<?php echo $this->__back_url()?>">
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
<table width="100%" cellspacing="0" cellpadding="0" style="border:0;">
  <tr height="30">
  	<td colspan="2" background="../clients/images/background.jpg"></td>
  </tr>
  <tr height="30" valign="bottom">
    <td height="19" align="left" valign="top" class="content-head" style="padding-left:20px;">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
 
 
  <tr height="30" valign="bottom">  
    <td width="23%" height="22" align="left" valign="top" class="content-head" style="padding-left:20px;"><strong>Select Product:</strong></td>
	<td width="77%" align="left" valign="top"><?php echo $comboBox;?><?php ERROR::writeError('product_id');?></td>
  </tr> 
  <?php if ($this->imgs):?>
  <tr>
  	<td>&nbsp;</td>
	<td style="padding-bottom:3px;"><img id="myimg" height="100" /><div style="display:none;"><?php echo $this->imgs;?></div></td>
  </tr>
  <?php endif;?>
 
   <tr height="30" valign="bottom">
     <td height="20" colspan="2" align="left" valign="middle" class="content-head"><hr /></td>
    </tr>
   <tr height="30" valign="bottom">
    <td height="30" align="left" valign="bottom" nowrap="nowrap" class="content-head" style="padding-left:20px;"><strong>Set Image Mode:
    </strong>
        <input type="hidden" id="srcimage" name="srcimage" value="<?php IO::writeData('srcimage');?>" />
      <input name="hidden" type="hidden" id="isusingsrcimage" value="" /></td>
    <td align="left" valign="bottom"><select name="select" onchange="javascript:SetModeChoseImage(this.value);">
      <option value="upload" selected="selected">&nbsp;&nbsp;&nbsp;Upload new image to server&nbsp;&nbsp;&nbsp;</option>
      <option value="link">&nbsp;&nbsp;&nbsp;Chose an existing image from host&nbsp;&nbsp;&nbsp;</option>
    </select></td>
  </tr>
   <tr id="row_link" height="30" valign="bottom">
    <td height="22" align="left" valign="top" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Chose from host:</span></td>
    <td align="left" valign="top"><img src="no-image.jpg"  height="130" id="srcimg" /></td>
  </tr>
  <tr id="row_upload">
    <td align="left" valign="top" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Upload new file:</span><span style="font-family: tahoma; font-size: 11px;"><br />
    </span></td>	
    <td align="left" valign="top"><input name="image" type="file" id="image" size="50"/><?php ERROR::writeError('image');?></td>
  </tr> <tr>
    <td align="left" valign="top" class="content-head" style="padding-left:20px;">Alternavite text: </td>
    <td align="left" valign="top"><?php echo GetAlternativeTextControl();?></td>
  </tr>
  <tr height="40" valign="middle">
  	<td></td>  	
	<td align="left">&nbsp;</td>
  </tr>
</table>
</form>
<script language="javascript" type="text/javascript">
function ShowIMG(id)
{
	if (document.getElementById('img_'+id))
	{
		document.getElementById('myimg').src = document.getElementById('img_'+id).src;
	}
}
ShowIMG(<?php echo IO::getID('product_id');?>);

var pp = '';
var isautoset = true;
function SetModeChoseImage(mode)//link, upload
{	
	var isusingsrcimage = document.getElementById('isusingsrcimage');
	var srcimage = document.getElementById('srcimage');
	var srcimg = document.getElementById('srcimg');
	var row_upload = document.getElementById('row_upload');
	var row_link = document.getElementById('row_link');
	
	if (mode == 'link')
	{
		isusingsrcimage.value = 'yes';
		if (!isautoset) 
		{
			srcimage.value = '';
		}
		srcimg.src = isautoset ? '<?php echo MYSITEROOT;?>/attachment/image/'+srcimage.value : 'no-image.jpg';
		row_link.style.display = '';
		row_upload.style.display = 'none';
		if (!isautoset)
		{
			if (pp)
			{
				pp.close();
			}
			pp = window.open('index.php?module=imagesmanager&mode=popup&srcimg=srcimg&srcimage=srcimage&flag=isusingsrcimage', 'pp', '');
		}
	}
	else //up
	{
		isusingsrcimage.value = 'no';
		srcimage.value = '';
		row_link.style.display = 'none';
		row_upload.style.display = '';
	}
	
	isautoset = false;
}
SetModeChoseImage('upload');
</script>
