<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>
<style type="text/css">
<!--
.ww {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #FF0000;
}
.d {
	color: #FF0000;
	font-weight: bold;
}
.xxx-style1 {
	color: #FF0000;
	font-style: italic;
}
-->
</style>

<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<td height="48"><?php if (ALI):?><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo MODULE_NAME;?>&function=insert&menu=<?php echo $menu_id;?>'" >
								<img src="../clients/images/addnew.png" name="new" align="middle" border="0" /><br />
								New</a><?php endif;?>
						</td>
						<td>&nbsp;</td>
						<td><?php if (ALD):?>
							<a class="toolbar" href="javascript:checkdelete('Bạn muốn xóa mẫu tin này không?','Xin vui lòng chọn mẫu tin để xóa!')" >
							<img src="../clients/images/delete.png"  align="middle" border="0" /><br />
							Delete</a><?php endif;?>
						</td>	
							
				</tr>
			</table>			
	</td>
</tr>
</table>
<table class="adminheading">
	<tr>
		<td valign="middle" nowrap="nowrap">
		<img src="../clients/icons/editor.gif" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;">
	  <p class="content-caption" style="padding-top:15px; padding-left:70px;"><?php echo $this->title;?></p>		
	  </td>
		<td align="right" valign="middle" nowrap="nowrap"><?php echo ALLOW_SHOW_DROPDOWNLIST_FILTER_VIEW ? (TITLE_FILTER_VIEW.$combobox) : '&nbsp;';?></td>		
	</tr>		
</table>

<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo MODULE_NAME;?>&function=delete" name="form" id="form"  style="margin:0">
<table width="100%" cellspacing="0"  border="0"cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
  <!--DWLayoutTable-->	
	 <tr valign="center">  	
	   <th height="20" align="center" valign="middle"><?php echo ALD ? '<input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)">' : '&nbsp;';?></th>
			<th align="center" valign="middle">No.</th>
			<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
			<th align="left" valign="middle" nowrap="nowrap" title="<?php echo $this->descriptionLangList[$i];?>" >State Name</th>
			<?php endfor;?>
			<th align="left" valign="middle" nowrap="nowrap" title="<?php echo $this->descriptionLangList[$i];?>" >Code</th>
			
			<?php if (ALSD):?><th  align="center" valign="middle" nowrap="nowrap" >Display <img src="../clients/images/icons/filesave.png" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th><?php endif?>		  
		    <?php if (ALSS):?><th  align="center" valign="middle" nowrap="nowrap" >Sort <img src="../clients/images/icons/filesave.png" alt="" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th><?php endif;?>
		    <th align="center" valign="middle" nowrap="nowrap" >Edit</th>
    </tr> 
		<?php for($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<?php if($row->display):?><tr><?php else:?><tr style="background:#cccccc;"><?php endif;?>
		 <td align="center" class="content-rows"><?php echo ALD ? "<input type=\"checkbox\" name=\"delete[]\" value=\"{$row->id}\">" : '&nbsp;';?></td>
			<td align="center" class="content-rows"><?php echo $stt++?></td>
			<?php for ($j=0; $j<count($this->field_NAME); $j++):?>
			<td  align="left" class="content-rows"><?php echo $row->{$this->field_NAME[$j]};?></td>
			<?php endfor;?>
			<td  align="left" class="content-rows"><?php echo $row->code;?></td>
			
			<?php if (ALSD):?><td align="center"  valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td><?php endif;?>
			<?php if (ALSS):?><td align="center" valign="middle" nowrap="nowrap"  class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering)?></td><?php endif;?> 
			<td align="center" valign="middle" nowrap="nowrap"  class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id?>"><img src="../clients/images/button/edit.gif" border="0" /></a></td></tr>
		  <?php $this->__auto_add_idlist($row->id); endfor;?>
</table>
	<?php echo $this->__auto_write_idlist();?>
</form>
<br />
<div style="width:100%" align="center"><?php print ($pagelist);?></div>
<br />

<script type="text/javascript" language="javascript">
function set_display()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_display';
	f.submit();
	return;
}
function set_istinh()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_istinh';
	f.submit();
	return;
}
function set_isfaq()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_isfaq';
	f.submit();
	return;
}
function set_isgallery()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_isgallery';
	f.submit();
	return;
}
function set_ordering()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_ordering';
	f.submit();
	return;
}
</script>