<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}?>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<td><a class="toolbar" href="index.php?module=<?php echo MODULE_CAT_NAME;?>&cat_id=<?php echo $this->__getGrandFatherID($product_id)?>" ><img src="../clients/images/back.png" align="middle" border="0" /><br />Back</a></td>
						<td>&nbsp;</td><td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo MODULE_NAME;?>&function=insert&product_id=<?php echo $product_id?>'" ><img src="../clients/images/addnew.png" align="middle" border="0" /><br />Add</a></td>
						<td>&nbsp;</td>
						<td>
							<a class="toolbar" href="javascript:checkdelete('Delete selected items ?','Please choose item')">
							<img src="../clients/images/delete.png"  align="middle" border="0" /><br />Delete</a>
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
		<td align="right" valign="middle" colspan="5">Filter by Product: <?php echo $comboBox;?>&nbsp;</td>		
	</tr>		
</table>
<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo MODULE_NAME;?>&function=delete" name="form" id="form" style="margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
   <tr valign="center">  	
	   <th align="center" valign="top" nowrap="nowrap"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th align="center" valign="top">No.</th>
			<th align="center" valign="top" nowrap="nowrap">Image</th>
			<th width="200" align="center" valign="top" nowrap="nowrap">Alternavite Text <img src="../clients/images/icons/filesave.png" title="Update" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_alt();" align="absmiddle" /></th>
			<th width="100" align="center" valign="top" nowrap="nowrap">Display <img src="../clients/images/icons/filesave.png" alt="Update" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>
			<th align="center" valign="top" nowrap="nowrap">Sort <img src="../clients/images/icons/filesave.png" alt="Update" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th>			  
	</tr> 
		<?php for($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<?php if($row->display):?><tr class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'"><?php else:?><tr style="background:#AAAAAA;"><?php endif;?>
			<td height="68" align="center" valign="middle" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id;?>"></td>
			<td align="center" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $stt++;?></td>
		  <td align="center" nowrap="nowrap" valign="middle" class="content-rows"><?php if (file_exists('../'.$row->image)): $size = @getimagesize('../'.$row->image);?><img src="<?php echo '../'.$row->image;?>" width="<?php echo WIDTH_SHOW;?>" border="0" style="cursor:pointer;" onclick="<?php echo $this->__show_popup('../'.$row->image, '', $size[0]+50, $size[1]+50);?>" title="<?php echo $row->alt;?>" /> <?php endif;?></td>
			<td align="center" valign="middle" class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->alt, '', 'alt');?></td>
			<td align="center" valign="middle" class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td>			
			<td width="70" align="center" valign="middle" nowrap="nowrap" class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering);?></td></tr>
		<?php $this->__auto_add_idlist($row->id); endfor;?>
</table>
<?php echo $this->__auto_write_idlist();?>
</form>
<br /><div style="width:100%" align="center"><?php print ($pagelist);?></div><br />

<script type="text/javascript" language="javascript">
function set_display()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_display';
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
function set_alt()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_alt';
	f.submit();
	return;
}
</script>