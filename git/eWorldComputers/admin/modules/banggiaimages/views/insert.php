<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>

<!-- ===================================================================================== -->
<style type="text/css">
<!--
.asdasds {color: #FF0000}
-->
</style>


<form action="" method="POST" enctype="multipart/form-data" name="form" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="40%" nowrap="nowrap" class="menudottedline">		
	  <div class="content-rows"><a href="index.php?"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:window.document.form.submit();"><img src="../clients/images/save.png" align="middle" border="0" /><br />
					Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo $this->module;?>&catid=<?php echo $cat_id;?>';">
					<img src="../clients/images/cancel.png"   align="middle" border="0" /><br />
					Cancel</a>
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
   <tr> <td width="13%" height="20" >&nbsp;</td>
   </tr>
  
 <tr> <td height="20" >&nbsp;</td><td><span class="asdasds"><br />
- file type  (<?php echo '*.'.implode(', *.', $this->uploadConfig['allowedTypes']);?>)</span> <br />
<span class="asdasds">- max file size: 2MB </span><br />
&nbsp;</td>
 </tr>
 <?php for ($i=0; $i<$this->countFile; $i++):?>
  	<tr>
      <td valign="top"  class="content-head" style="padding-left:20px;" >File <?php echo $i+1;?>:</td>
	  <td width="87%" colspan="1" align="left"  valign="bottom" class="content-rows"><input name="image<?php echo $i;?>" type="file" id="image<?php echo $i;?>" size="50" />
       <span class="err-msg"> <?php $this->__writeError("image{$i}",'');?></span></td>
   </tr>
   <?php endfor;?>
  <tr> <td height="43" >&nbsp;</td>
    <td height="43" valign="top" >&nbsp;</td>
  </tr>   
</table>
</form>