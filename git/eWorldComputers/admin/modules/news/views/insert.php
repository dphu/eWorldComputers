<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>
<form method="POST" action="" name="form" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><a href="index.php?"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:window.document.form.submit();"><img src="../clients/images/save.png" align="middle" border="0" /><br />Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="javascript:window.location.href='<?php echo  $this->__back_url()?>';">
					<img src="../clients/images/cancel.png" align="middle" border="0" /><br />
					Cancel</a>
					</td>			
				</tr>
			</table>			
	  </td>
</tr>
</table>

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

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr height="30">
  	<td colspan="2"  background="../clients/images/background.jpg"></td>
  </tr> 
   <tr> <td width="17%" height="20" >&nbsp;</td>
   </tr>
  

  
  <tr>
			    <td align="right" nowrap="nowrap" style="padding-left:20px;" class="content-head">Rewrite URL Setting:</td>
			    <td align="left" class="content-head">&nbsp;</td>
    </tr>
  <tr>
  	  <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="dsffsdfsdfsdfdf"><em>Default Path</em>:</span> </td>
  	  <td  align="left"><span id="RealPath"><?php echo $this->__getRealPath(IO::getPOST('id'));?></span><input name="id" id="id" type="hidden" value="<?php echo IO::getPOST('id');?>" /></td>
    </tr><tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="dsffsdfsdfsdfdf"><span class="style1"><em>Replace With</em></span>:</span> </td>
    <td  align="left"><span id="idVirtualPath"><?php echo BASEURL.INDEX.'news/';?></span>&nbsp;<input name="virtualurl" type="text" id="virtualurl" value="<?php IO::writeData('virtualurl');?>" size="54" style="height:18px;"/>
      <?php ERROR::writeError('virtualurl');?></td>
  </tr>
	 <tr>
      <td colspan="2" align="right" valign="middle" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
  <tr>
			    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="asasgffgfdg">Page Configuations:</span></td>
			    <td align="left"  style="padding-right:2px;">&nbsp;</td>
			    <td align="left">&nbsp;</td>
    </tr>
	<tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Page title</em>: </td>
    <td align="left"><input name="pagetitle" type="text" id="pagetitle" value="<?php IO::writeData('pagetitle');?>" size="120" style="height:18px;"/></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Meta keyword</em>: </td>
    <td  align="left"><input name="metakeyword" type="text" id="metakeyword" value="<?php IO::writeData('metakeyword');?>" size="120" style="height:18px;"/></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em>Meta description</em>: </td>
    <td  align="left"><input name="metadescription" type="text" id="metadescription" value="<?php IO::writeData('metadescription');?>" size="120" style="height:18px;"/></td>
  </tr>
	 <tr>
    <td colspan="4" align="right" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
 <?php if ($isCatTinh):?>

 <tr>
  	   <td valign="top" class="content-head" style="padding-left:20px;" >Tỉnh/Thành:</td>
  	   <td align="left"  valign="bottom" class="content-rows"><?php echo __createComBoBox($this->db, 'tinh_id', TABLE_TINH_NAME, NULL, abs(intval(IO::getPOST('tinh_id'))), $this->keyLangList[0], NULL, NULL);?></td>
    </tr>
	<tr><td colspan="2"><hr /></td></tr>
	<?php endif;?>
 <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
  	 
  	 <tr>
      <td valign="top" class="content-head" style="padding-left:20px;" >Title: (<font color="#FF0000"><?php echo strtoupper($this->keyLangList[$i]);?></font>)</td>
	  <td align="left"  valign="bottom" class="content-rows"><input type="text" size="45" id="<?php echo $this->field_TITLE[$i];?>" name="<?php echo $this->field_TITLE[$i];?>" value="<?php IO::writeData($this->field_TITLE[$i]);?>" style="height:15px;"/><?php ERROR::writeError($this->field_TITLE[$i]);?></td>
   </tr>
   <?php if(USE_SUMMERY):?>
    <tr>
      <td class="content-head" style="padding-left:20px;" valign="top" >Summary: (<font color="#FF0000"><?php echo strtoupper($this->keyLangList[$i]);?></font>)</td>
      <td class="content-rows" align="left" ><?php echo $this->__create_FCK($this->field_DESCRIPTION[$i], '98%' , '200' , isset($_POST[$this->field_DESCRIPTION[$i]]) ? IO::formatOutput($_POST[$this->field_DESCRIPTION[$i]]) : ''); ?></td>
    </tr>
    <?php endif;?>
    <tr>
      <td valign="top" nowrap="nowrap" class="content-head" style="padding-left:20px;" >Content: (<font color="#FF0000"><?php echo strtoupper($this->keyLangList[$i]);?></font>)</td>
      <td class="content-rows" align="left" ><?php echo $this->__create_FCK($this->field_CONTENT[$i], '98%', '400', isset($_POST[$this->field_CONTENT[$i]]) ? IO::formatOutput($_POST[$this->field_CONTENT[$i]]) : ''); ?></td>
    </tr> 
	<?php if (isset($_SESSION['thuananSMN']) && $_SESSION['thuananSMN'] === true):?>
	<tr>
      <td valign="top" nowrap="nowrap" class="content-head" style="padding-left:20px;" >Form Config: <span class="content-head">(<font color="#FF0000"><?php echo strtoupper($this->keyLangList[$i]);?></font>)</span></td>
      <td class="content-rows" align="left"><input type="text" size="45" id="<?php echo $this->field_FORMCONFIG[$i];?>" name="<?php echo $this->field_FORMCONFIG[$i];?>" value="<?php IO::writeData($this->field_FORMCONFIG[$i]);?>" style="height:15px;"/></td>
    </tr>
	<?php endif;?>
 <?php if ($i<count($this->keyLangList)-1) echo '<tr><td colspan="2" height="20" ><hr /></td></tr>';?>
 <?php endfor;?> 
</table>
</form>