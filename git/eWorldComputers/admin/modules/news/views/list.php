<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};
?>
<style type="text/css">
<!--
.ww {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #FF0000;
}
.sadsd {
	color: #FF0000;
	font: bold;
}
.style1 {color: #FF0000}
-->
</style>

<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<?php if($canadd):?>
						<td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo MODULE_NAME;?>&function=insert&cat=<?php echo $cat_id;?>'" >
								<img src="../clients/images/addnew.png" align="middle" border="0" /><br />Add</a>
				  </td>
						<td>&nbsp;</td>
						<?php endif;?>
						<td>
							<a class="toolbar" href="javascript:checkdelete('Delete selected items ?','Please choose item!')" >
							<img src="../clients/images/delete.png"  align="middle" border="0" /><br />
						  Delete</a>
				  </td>	
							
				</tr>
			</table>			
	</td>
</tr>
</table>
<table class="adminheading">
	<tr>
		<td>
		<img src="../clients/icons/editor.gif" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;"><p class="content-caption" style="padding-top:15px; padding-left:70px;"><?php echo $this->title;?></p></td>
		<td align="right" valign="middle"><?php echo ALLOW_SHOW_DROPDOWNLIST_FILTER_VIEW ? "Group: {$cbmn}" : NULL;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category: <?php echo $cb;?>&nbsp;&nbsp;&nbsp;
 </td>		
	</tr>		
</table>

<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo MODULE_NAME;?>&function=delete" name="form" id="form"  style="margin:0">
<table width="100%" cellspacing="0"  border="0"cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
  <!--DWLayoutTable-->	
	 <tr valign="center">  	
	   <th height="20" align="center" valign="middle"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th align="center" valign="middle">No.</th>
			<th  align="left" valign="middle" nowrap="nowrap" >Configuration Settings</th>
			<?php if($isCatTinh):?>
			<?php endif;?>	
			<th  align="left" valign="middle" nowrap="nowrap" >Title</th>
			<?php if (USE_SUMMERY):?><th  align="left" valign="middle" nowrap="nowrap" >Summary</th><?php endif;?>
			<?php if (USE_DATETIME):?><th  align="center" valign="middle" nowrap="nowrap" >Cập nhật </th><?php endif?>
			<?php if (USE_HIDDENTTLE):?><th  align="center" valign="middle" nowrap="nowrap" >Hide title <img src="../clients/images/icons/filesave.png" width="14" height="15" align="absmiddle" style="cursor:pointer;" onclick="javascript:set_ishidetitle();" /> </th><?php endif;?>
			<?php if (USE_NEW):?><th  align="center" valign="middle" nowrap="nowrap" style="display:none;" >New <img src="../clients/images/icons/filesave.png" width="14" height="15" align="absmiddle" style="cursor:pointer;" onclick="javascript:set_isnew();" /></th><?php endif;?>
			<th  align="center" valign="middle" nowrap="nowrap" >Display <img src="../clients/images/icons/filesave.png" width="14" height="15" style="cursor:pointer;" onclick="javascript:set_display();" /></th>		
                <th  align="center" valign="middle" nowrap="nowrap" >Sort <img src="../clients/images/icons/filesave.png" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th> 
               <?php if (isset($_SESSION['thuananSMN']) && $_SESSION['thuananSMN'] === true):?><th align="center" valign="middle" nowrap="nowrap" > Form</th>
               <?php endif;?>
    </tr> 
		<?php for ($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<?php if ($row->display):?><tr><?php else:?><tr style="background:#DDDDDD;"><?php endif;?>
		  <td align="center" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id?>"></td>
			<td align="center" class="content-rows"><?php echo $stt++?></td>
			<td align="left"  valign="middle"  class="content-rows"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="left" valign="top" class="xxxxxxxxxxxxx">Default url:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo $this->__getRealPath($row->id);?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="xxxxxxxxxxxxx">Rewriting url:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo $this->__getVirtualPath($row->id);?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="xxxxxxxxxxxxx">Page title:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($row->pagetitle && strlen($row->pagetitle)) ? $row->pagetitle : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="xxxxxxxxxxxxx">Meta keyword:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($row->metakeyword && strlen($row->metakeyword)) ? $row->metakeyword : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="xxxxxxxxxxxxx">Meta description:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($row->metadescription && strlen($row->metadescription)) ? $row->metadescription : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
            </table></td>
			<td align="left"  valign="middle"  class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&amp;function=edit&amp;id=<?php echo $row->id?>" ><?php echo $row->{'title_'.$this->keyLangList[0]};?></a></td>
			<?php if (USE_SUMMERY):?><td align="left"  valign="middle"  class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id?>" ><?php echo $row->{'description_'.$this->keyLangList[0]};?></a></td><?php endif;?>
			<?php if (USE_DATETIME):?><td align="center"  valign="middle"  class="content-rows"><?php echo date('d-m-Y h:i a', $row->date);?></td><?php endif;?>
			<?php if (USE_HIDDENTTLE):?><td align="center"  valign="middle" nowrap="nowrap"  class="content-rows"><?php echo $this->__auto_write_checkbox('ishidetitle', $row->id, $row->ishidetitle)?></td><?php endif;?>
			<?php if (USE_NEW):?><td align="center"  valign="middle" nowrap="nowrap"  class="content-rows" style="display:none;"><?php echo $this->__auto_write_checkbox('isnew', $row->id, $row->isnew)?></td><?php endif;?>
			<td align="center"  valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td>			
			
			<td align="center" valign="middle" nowrap="nowrap"  class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering)?></td><?php if (isset($_SESSION['thuananSMN']) && $_SESSION['thuananSMN'] === true):?>
			<td align="center" valign="middle" nowrap="nowrap"  class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=clearformconfig&id=<?php echo $row->id?>">Clear</a></td>
			<?php endif;?></tr>
		  <?php $this->__auto_add_idlist($row->id); endfor;?>
</table>
	<?php echo $this->__auto_write_idlist()?>
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
function set_isnew()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_isnew';
	f.submit();
	return;
}
function set_ishidetitle()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_ishidetitle';
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
