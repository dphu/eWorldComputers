<?php defined('IN_SYSTEM') or die('<hr>');?>

<style type="text/css">
<!--
.sdsd {color: #FF0000}
.dsffsdfsdfsdfdf {
	font-size: 12px;
	font-style: italic;
	color: #0000FF;
	font-weight:normal;
}
.style1 {font-size: 12px}
.style2 {font-size: 12px; font-style: italic; color: #0000FF; }
-->
</style>

<form method="POST" action="" name="form" id="form" style="margin:0" enctype="multipart/form-data">
<!-- ===================================================================================== -->
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="40%" nowrap="nowrap" class="menudottedline">		
	  <div class="content-rows"><a href="?"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png"  align="middle" border="0" /><br />Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="<?php echo $this->queryString?>">
					<img src="../clients/images/cancel.png"  align="middle" border="0" /><br />Cancel</a>
					</td>			
				</tr>
			</table>			
	  </td>
</tr>
</table>
<!-- ===================================================================================== -->
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
<br />
<table width="100%" cellspacing="0" cellpadding="0" style="border:0;">
  <tr height="30">
  	<td colspan="2" background="../clients/images/background.jpg"></td>
  </tr>	  
	<tr><td height="10" colspan="2"></td></tr>	<tr>
      <td width="150" height="25" align="right" valign="middle" nowrap="nowrap" class="content-head" >Parent: </td>
      <td align="left" valign="middle" style="padding-left:10px;"><?php echo $comboBox;?></td>
    </tr>
	<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
	<tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head"  title="<?php echo $this->descriptionLangList[$i];?>">Title (<span class="sdsd"><?php echo strtoupper($this->keyLangList[$i]);?></span>)</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="<?php echo $this->field_NAME[$i];?>" type="text" size="40" value="<?php IO::writeData($this->field_NAME[$i]);?>" style="height:20px;"/><?php ERROR::writeError($this->field_NAME[$i], '*');?></td>
  </tr>
  <?php endfor;?>
   <tr>
      <td colspan="2" align="right" valign="middle" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
	 <tr>
			    <td align="right" nowrap="nowrap" style="padding-left:20px;" class="content-head">Rewrite URL Setting:</td>
			    <td colspan="3" align="left" class="content-head">&nbsp;</td>
    </tr>
  <tr>
  	  <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="dsffsdfsdfsdfdf"><em>Default Path</em>:</span> </td>
  	  <td colspan="2" align="left"><span id="RealPath"><?php echo $this->__getRealPath(IO::getPOST('parent_id'), IO::getPOST('id'));?></span><input name="id" id="id" type="hidden" value="<?php echo IO::getPOST('id');?>" /></td>
    </tr><tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><span class="dsffsdfsdfsdfdf"><span class="style1"><em>Replace With</em></span>:</span> </td>
    <td colspan="2" align="left"><span id="idVirtualPath"><?php echo BASEURL.INDEX.(IO::getPOST('parent_id') ? 'category/' : 'by/');?></span>&nbsp;<input name="virtualurl" type="text" id="virtualurl" value="<?php IO::writeData('virtualurl');?>" size="54" style="height:18px;"/>      <?php ERROR::writeError('virtualurl');?>    </td>
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
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em class="dsffsdfsdfsdfdf">Page title</em>: </td>
    <td align="left"><input name="pagetitle" type="text" id="pagetitle" value="<?php IO::writeData('pagetitle');?>" size="120" style="height:18px;"/></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em class="dsffsdfsdfsdfdf">Meta keyword</em>: </td>
    <td  align="left"><input name="metakeyword" type="text" id="metakeyword" value="<?php IO::writeData('metakeyword');?>" size="120" style="height:18px;"/></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" class="content-head" style="padding-left:20px;"><em class="dsffsdfsdfsdfdf">Meta description</em>: </td>
    <td  align="left"><input name="metadescription" type="text" id="metadescription" value="<?php IO::writeData('metadescription');?>" size="120" style="height:18px;"/></td>
  </tr>
	
	 <tr id="id_FCK_0">
      <td colspan="2" width="100%" align="right" valign="top" nowrap="nowrap" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <?php for ($i=0; $i<count($this->keyLangList); $i++):?>
    <tr>
    <td colspan="4" align="right" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
   
    <tr>
      <td width="150" align="right" valign="top" nowrap="nowrap"  class="content-head" style="" >Description (<font color="#FF0000"><?php echo $this->keyLangList[$i];?></font>):</td>
	  <td colspan="1" align="left"   style="padding-left:10px;" valign="bottom" class="content-rows"><?php echo $this->__create_FCK($this->field_DESCRIPTION[$i], '98%' , '200' , isset($_POST[$this->field_DESCRIPTION[$i]]) ? IO::formatOutput($_POST[$this->field_DESCRIPTION[$i]]) : ''); ?></td>
   </tr>
  <?php endfor;?>
   <tr>
     <td colspan="2" align="right" valign="top" nowrap="nowrap"  class="content-head" style="" ><hr /></td>
    </tr>
   <tr>
      <td align="right" valign="top" nowrap="nowrap"  class="content-head" style="" >Left Image Present: </td>
	  <td colspan="1" align="left"  valign="bottom" class="content-rows" style="padding-left:10px;"><?php echo $this->__create_FCK('lim', '98%' , '450' , isset($_POST['lim']) ? IO::formatOutput($_POST['lim']) : ''); ?></td>
   </tr>
</table>
</td>
      </tr>
  <tr height="40" valign="middle">
  	<td></td>  	
	<td align="left"><span style="font-family: tahoma; font-size: 11px;"> (<font color="#FF0000">*</font>) : Is required.</span></td>
  </tr>   
</table>
</form>
<script type="text/javascript" language="javascript">
	function rs(){ var a = document.getElementById('form'); a.refresh();}
	var RealPathObjinnerHTML = '';
	var VirtualPathObjinnerHTML = '';
	function SetRealPath(value)
	{
		var RealPathObj = document.getElementById('RealPath');
		var VirtualPathObj = document.getElementById('idVirtualPath');
		
		if (RealPathObjinnerHTML == '') RealPathObjinnerHTML = RealPathObj.innerHTML;
		if (VirtualPathObjinnerHTML == '') VirtualPathObjinnerHTML = VirtualPathObj.innerHTML;
		
		if (value == '0') //root
		{
			RealPathObjinnerHTML = RealPathObjinnerHTML.replace('category/', 'category/'); 
			VirtualPathObjinnerHTML = VirtualPathObjinnerHTML.replace('/category/', '/by/'); 
			
			__setDisplayFCK('none')
		}
		else //category
		{
			RealPathObjinnerHTML = RealPathObjinnerHTML.replace('category/', 'category/'); 
			VirtualPathObjinnerHTML = VirtualPathObjinnerHTML.replace('/by/', '/category/'); 
			
			__setDisplayFCK('');
		}
		
		RealPathObj.innerHTML = RealPathObjinnerHTML;
		VirtualPathObj.innerHTML = VirtualPathObjinnerHTML;
	}
	SetRealPath('<?php echo intval(IO::getPOST('parent_id'));?>');
	
	function __setDisplayFCK(display)
	{
		document.getElementById('id_FCK_0').style.display = display;
	}
	
</script>