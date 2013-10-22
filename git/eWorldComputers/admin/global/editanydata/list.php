<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};
?>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="40%" nowrap="nowrap" class="menudottedline">		
	<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<td><a class="toolbar" href="index.php?module=block&function=insert">
								<img src="../clients/images/addnew.png" align="middle" border="0" /><br />
								Add</a>
						</td>
						<?php if (count($rows)):?>
						<td>&nbsp;</td>
						<td>
							<a class="toolbar" href="javascript: checkdelete('Delete selected items ?','Please choose item!')" >
							<img src="../clients/images/delete.png"  align="middle" border="0" /><br />Delete</a>
						</td>	
					    <?php endif;?>		
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
		<td align="right" valign="middle">&nbsp;</td>		
	</tr>		
</table>
<?php $idlist = '0';?>
<form method="POST" action="index.php?module=block&function=delete" name="form" id="form"  style="margin:0">
<table cellspacing="0"  border="0"cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist" width="100%">
	 <tr valign="center">  	
	   <th height="20" align="center" valign="middle" nowrap="nowrap"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th align="center" valign="middle" nowrap="nowrap">No.</th>
			<th align="left" valign="middle" nowrap="nowrap" >Block ID</th>
			<th width="110"  align="center" valign="middle" nowrap="NOWRAP" >Page settings&nbsp;<img src="../clients/images/icons/filesave.png"width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ispagesettings();" /></th>
			<th width="80"  align="center" valign="middle" nowrap="nowrap" >Enable&nbsp;<img src="../clients/images/icons/filesave.png"width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>		
		  
		    <th align="center" valign="middle" nowrap="nowrap" >Edit </th>
    </tr> 
		<?php $stt=1; for ($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<?php if($row->display):?>
			<tr class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'">
		<?php else:?>
			<tr style="background:#cccccc; color:#ffffff; font-weight:bold; font-style:italic;">
		<?php endif;?>
		  <td align="center" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id?>"></td>
			<td align="center" class="content-rows" style="border-left:1px solid #eeeeee;"><?php echo $stt++?></td>
			<td  align="left"  class="content-rows"><a href="index.php?module=block&function=edit&id=<?php echo $row->id;?>" style="color:#000000;"><?php echo $row->blockid;?></a></td>
			<td align="center" valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('ispagesettings', $row->id, $row->ispagesettings);?></td>
			<td align="center" valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display);?></td> 
			<td align="center" valign="middle"  class="content-rows"><a href="index.php?module=block&function=edit&id=<?php echo $row->id;?>"><img src="../clients/images/button/edit.gif" border="0" /></a></td>
		  <?php $this->__auto_add_idlist($row->id); endfor;?>
		  </tr>
</table>
	<?php echo $this->__auto_write_idlist()?>
</form>
<br /><br />

<script type="text/javascript" language="javascript">
function set_display()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=block&function=set_display';
	f.submit();
	return;
}
function set_ispagesettings()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=block&function=set_ispagesettings';
	f.submit();
	return;
}
</script>