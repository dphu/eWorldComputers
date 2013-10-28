<?php 
defined('IN_SYSTEM') or die('<hr>');
?>

<!-- ===================================================================================== -->
<style type="text/css">
<!--
.ssssssssss {
	color: #FF0000;
	font-weight: bold;
}
.assss {color: #000099}
.asasgffgfdg {
	color: #0000CC;
	font-style: italic;
	font-weight:normal;
	text-decoration:underline;
}
.r45 {
	color: #007700;
	font-style: italic;
}
-->
</style>

<form method="POST" action="" name="form" id="form" enctype="multipart/form-data" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td nowrap="nowrap" class="menudottedline">		
	  <div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td align="right" nowrap="nowrap" class="menudottedline" style="padding:0px;">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png" align="middle" border="0" /><br />
					Update</a>
					</td>
					<td nowrap="nowrap">&nbsp;</td>
					<td nowrap="nowrap">
					<a class="toolbar" href="javascript:window.location.href='<?php echo $this->__back_url();?>';">
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
		<td align="right" valign="top">&nbsp;</td>
		<td align="right" valign="top">&nbsp;</td>
		<td valign="top">&nbsp;</td>
	</tr>		
</table>
<!-- ====================================================================================== -->
<table width="100%" cellspacing="0" cellpadding="0" style="border:0;">
  <tr height="30">
  	<td colspan="4" background="../clients/images/background.jpg"></td>
  </tr> 
  <!-- 1 nhom san pham -->
  <tr height="30" valign="bottom">  
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;">Category : </td>
    <td align="left" class="content-head" style="padding-left:20px;">&nbsp;</td>
    <td colspan="2" align="left"><?php echo $cat_selection;?><?php ERROR::writeError('cat_id');?></td>
  </tr>
  <?php for ($i=0; $i<count($this->keyLangList); $i++):?> 
  <tr>  
    <td width="7%" align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;">Name (<span class="ssssssssss"><?php echo strtoupper($this->keyLangList[$i]);?></span>): </td>
	<td width="14%" align="left" class="content-head"></td>
	<td colspan="2" align="left"><input name="<?php echo $this->field_NAME[$i];?>" type="text" id="<?php echo $this->field_NAME[$i];?>" value="<?php IO::writeData($this->field_NAME[$i]);?>" size="34" style="height:18px;"/><?php ERROR::writeError($this->field_NAME[$i]);?></td>
  </tr>
  <?php endfor;?>
  <tr>  
    <td width="7%" align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;">SKU : </td>
	<td width="14%" align="left" class="content-head"></td>
	<td colspan="2" align="left"><input name="code" type="text" id="code" value="<?php IO::writeData('code');?>" size="34" style="height:18px;"/><?php ERROR::writeError('code', '*');?></td>
  </tr>
  <?php // if (USE_PRICE):?>
  	
  	<tr>  
    <td width="7%" align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;">Price : </td>
	<td width="14%" align="left" class="content-head"></td>
	<td colspan="2" align="left"><input name="price" type="text" id="price" value="<?php IO::writeData('price');?>" size="34" style="height:18px;"/><?php ERROR::writeError('price', '*');?></td>
    
  </tr>
  <tr>  
    <td width="7%" align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;">Quantity : </td>
	<td width="14%" align="left" class="content-head"></td>
	<td colspan="2" align="left"><input name="quantity" type="text" id="price" value="<?php IO::writeData('quantity');?>" size="34" style="height:18px;"/><?php ERROR::writeError('quantity', '*');?></td>
    
  </tr>
  <?php //endif;?>
  <tr>
    <td colspan="4" align="right" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
  <tr>
			    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Rewrite URL Setting:</span></td>
			    <td align="left" class="content-head">&nbsp;</td>
			    <td align="left" style="padding-right:2px;">&nbsp;</td>
			    <td width="99%" align="left">&nbsp;</td>
    </tr>
  <tr>
  	  <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Default Value</em>: </td>
  	  <td align="right" class="content-head">&nbsp;</td>
  	  <td colspan="2" align="left"><?php echo $this->__getRealPath(IO::getPOST('id'));?><input name="id" id="id" type="hidden" value="<?php echo IO::getPOST('id');?>" /></td>
    </tr><tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Replace With</em>: </td>
    <td align="right" nowrap="nowrap" class="content-head" style="font-weight:normal;">&nbsp;</td>
    <td colspan="2" align="left"><?php echo BASEURL.INDEX.'product/';?>&nbsp;<input name="virtualurl" type="text" id="virtualurl" value="<?php IO::writeData('virtualurl');?>" size="54" style="height:18px;"/>
      <?php ERROR::writeError('virtualurl');?></td>
  </tr>
	 <tr>
    <td colspan="4" align="right" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
	<tr>
			    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Page Configuations:</span></td>
			    <td align="left" class="content-head">&nbsp;</td>
			    <td align="left" style="padding-right:2px;">&nbsp;</td>
			    <td align="left">&nbsp;</td>
    </tr>
	<tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Page title</em>: </td>
    <td align="right" nowrap="nowrap" class="content-head" style="font-weight:normal;">&nbsp;</td>
    <td colspan="2" align="left"><input name="pagetitle" type="text" id="pagetitle" value="<?php IO::writeData('pagetitle');?>" size="120" style="height:18px;"/></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Meta keyword</em>: </td>
    <td align="right" nowrap="nowrap" class="content-head" style="font-weight:normal;">&nbsp;</td>
    <td colspan="2" align="left"><input name="metakeyword" type="text" id="metakeyword" value="<?php IO::writeData('metakeyword');?>" size="120" style="height:18px;"/></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Meta description</em>: </td>
    <td align="right" nowrap="nowrap" class="content-head" style="font-weight:normal;">&nbsp;</td>
    <td colspan="2" align="left"><input name="metadescription" type="text" id="metadescription" value="<?php IO::writeData('metadescription');?>" size="120" style="height:18px;"/></td>
  </tr>
	 <tr>
    <td colspan="4" align="right" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
  <?php for ($fieldCount=0; $fieldCount<count($this->extFormView[LANG_KEY]); $fieldCount++):?>
	  <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
	  	  <?php $fieldsList = isset($this->extFormView[$this->keyLangList[$i]]) ? $this->extFormView[$this->keyLangList[$i]] : $this->extFormView[LANG_KEY];?>
		  <?php 
		  		$fName = "{$this->keyLangList[$i]}_f{$fieldCount}";
				if (!isset($_POST[$fName])) {
					$fValue=isset($fieldsList[$fieldCount])?$fieldsList[$fieldCount]:$this->extFormView[LANG_KEY][$fieldCount];
				} else {
					$fValue = $_POST[$fName];
				}	
				$vName = "{$this->keyLangList[$i]}_v{$fieldCount}"; 
			?>
	  <?php endfor;?>
  <?php endfor;?>
    <tr>
      <td align="right" valign="top" nowrap="nowrap" class="content-head" style="padding-left:20px;">Set Image Mode: </td>
      <td align="left" valign="top" nowrap="nowrap" class="content-head" style="padding-left:2px;"><span class="content-head" style="padding-left:2px;"><span class="content-head" style="padding-left:20px;">
        <input type="hidden" id="srcimage" name="srcimage" value="<?php IO::writeData('srcimage');?>" /><input type="hidden" id="isusingsrcimage" value="" />
      </span></span></td>
      <td colspan="2" align="left"><select onchange="javascript:SetModeChoseImage(this.value);">
        <option value="upload" selected="selected">&nbsp;&nbsp;&nbsp;Upload new image to server&nbsp;&nbsp;&nbsp;</option>
        <option value="link" <?php echo IO::getPOST('srcimage') ? 'selected="selected"' : '';?>>&nbsp;&nbsp;&nbsp;Chose an existing image from host&nbsp;&nbsp;&nbsp;</option>
      </select></td>
    </tr>
    <tr id="row_link">
      <td align="right" valign="top" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Chose from host:</span></td>
      <td align="left" valign="top" nowrap="nowrap" class="content-head" style="padding-left:2px;">&nbsp;</td>
      <td colspan="2" align="left" valign="top"><img id="srcimg" height="<?php echo THUMBNAIL_H;?>" src="no-image.jpg" /></td>
    </tr>
    <tr id="row_upload">
    <td align="right" valign="top" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Upload new file:</span></td>	
    <td align="left" valign="top" nowrap="nowrap" class="content-head" style="padding-left:2px;"><i class="ssssssssss" style="display:none;">(<?php echo THUMBNAIL_W;?> x <?php echo THUMBNAIL_H;?>)</i></td>
    <td colspan="2" align="left"><input name="image" type="file" class="form-field" id="image" size="34"/><?php ERROR::writeError('image');?><?php if (isset($_POST['oldimage'])):?><input name="oldimage" type="hidden" id="oldimage" value="<?php echo IO::getPost('oldimage');?>" /><?php if (file_exists('../' . IO::getPost('oldimage'))): echo '<br /><img src="../' . IO::getPost('oldimage') . '" style="margin-bottom:5px;" />';?><?php endif;?><?php endif;?></td>
  </tr>
  <?php if (USE_DESC) for ($i=0; $i<count($this->keyLangList); $i++):?> 
  <tr>
    <td height="87" align="right" valign="top" class="content-head" style="padding-left:20px;" title="<?php echo $this->descriptionLangList[$i];?>">Alternavite Text:&nbsp;</td>
    <td height="87" align="left" valign="top" class="content-head" style="padding-left:2px;" title="<?php echo $this->descriptionLangList[$i];?>">&nbsp;</td>
    <td colspan="2" align="left" valign="top"><?php echo GetAlternativeTextControl();?></td>
  </tr>
  <tr>
    <td height="87" align="right" valign="top" class="content-head" style="padding-left:20px;" title="<?php echo $this->descriptionLangList[$i];?>">Description : </td>	
    <td height="87" align="left" valign="top" class="content-head" style="padding-left:2px;" title="<?php echo $this->descriptionLangList[$i];?>">(<span class="ssssssssss"><?php echo strtoupper($this->keyLangList[$i]);?></span>)</td>
    <td colspan="2" align="left" valign="top"><?php echo $this->__create_FCK($this->field_DESC[$i] , '95%' , '300' , isset($_POST[$this->field_DESC[$i]]) ? IO::formatOutput($_POST[$this->field_DESC[$i]]) : ''); ?></td>
 </tr>
 <?php endfor;?>
</table>
</form><br />
<br />
<br />
<script language="javascript" type="text/javascript">
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
SetModeChoseImage('<?php echo IO::getPOST('srcimage') ? 'link' : 'upload';?>');
</script>
