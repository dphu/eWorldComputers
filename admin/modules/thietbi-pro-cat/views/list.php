<?php defined('IN_SYSTEM') or die('<hr>');?>
<style type="text/css">
<!--
.wwew {color: #FF0000}
-->
</style>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="40%" nowrap="nowrap" class="menudottedline">
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
		<td class="menudottedline" align="right">
				<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
					<tr valign="middle" align="center">
							<td><a class="toolbar" href="javascript:window.location.href='?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=insert'" >
									<img src="../clients/images/addnew.png" align="middle" border="0" /><br />Add</a>
							</td>
							<td>&nbsp;</td>
							<td>
								<a class="toolbar" href="javascript:checkdelete('Delete selected items ?','Please choose item!')" ><img src="../clients/images/delete.png"  align="middle" border="0" /><br />Delete</a>
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
<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=delete" name="form" id="form" style="margin:0">
	<table width="100%" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
		<tr valign="center">
		  <th width="15" align="center" valign="middle"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th width="40" align="center" valign="middle" nowrap="nowrap" style="font-size:11px;">No.</th>
			<th width="50" align="center" valign="middle" nowrap="nowrap"  style="font-size:11px;">Edit</th>
			<th align="left" valign="middle" nowrap="nowrap" style="font-size:11px;" >Configuration Settings</th>
			<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
				<th align="left" valign="middle" nowrap="nowrap"  style="font-size:11px;">Title</th>
			    <?php endfor;?>
			<th width="60" align="center" valign="middle" nowrap="NOWRAP" style="font-size:11px;">Sort <img src="../clients/images/icons/filesave.png" alt="Cập nhật vị trí" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th>
			<th width="80" align="center" valign="middle" nowrap="nowrap" style="font-size:11px;">Display<img src="../clients/images/icons/filesave.png" alt="Cập nhật thuộc tính hiển thị" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>
			<th width="90" align="center" valign="middle" nowrap="nowrap"  style="font-size:11px;">Default</th>
		</tr>
		<!-- main cats lst -->
		<?php for($i=0; $i<count($rows); $i++)://main cat?>
			<?php $row = $rows[$i];?>
			<tr align="right" class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'" style="font-weight:bold; color:#FF0000; background-color:#D4DFAA;">
				<td align="center" valign="middle" class="content-rows">
					<input type="checkbox" name="delete[]" value="<?php echo $row->id?>">				</td>
				<td align="center" valign="middle"  class="content-rows">
					<?php echo $stt++;?>				</td>
				<td align="center" valign="middle" nowrap="nowrap" class="content-rows" style="color:#000000; font-weight:normal;"><a href="index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=edit&id=<?php echo $row->id?>" title="Click for edit" ><img src="../clients/images/button/edit.gif" border="0" /></a></td>
				<td align="left" valign="middle" nowrap="nowrap" class="content-rows" style="color:#000000; font-weight:normal;"><br /><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Default url:</td>
                <td align="left" valign="top" nowrap="nowrap">&nbsp;<u><?php echo $this->__getRealPath($row->parent_id, $row->id);?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Rewriting url:</td>
                <td align="left" valign="top" nowrap="nowrap">&nbsp;<u><?php echo $this->__getVirtualPath($row->id);?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Page title:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($row->pagetitle && strlen($row->pagetitle)) ? $row->pagetitle : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Meta keyword:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($row->metakeyword && strlen($row->metakeyword)) ? $row->metakeyword : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Meta description:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($row->metadescription && strlen($row->metadescription)) ? $row->metadescription : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
            </table></td>
				<?php for ($j=0; $j<count($this->keyLangList); $j++):?>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows">
						<a href="index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=edit&id=<?php echo $row->id?>" title="Click for edit" ><?php echo $row->{$this->field_NAME[$j]};?></a></td>
				<?php endfor;?>
				<td align="center" valign="middle" class="content-rows">
					<?php $this->__auto_write_textbox_ordering($row->id, $row->ordering, 'size="2" maxlength="5" style="text-align:center; font-weight:bold; color:#ff0000; background:#ffff00;"');?>				</td>
				<td align="center" valign="middle" class="content-rows">
					<?php echo $this->__auto_write_checkbox('display', $row->id, $row->display);?>				</td>
				<td align="center" valign="middle" class="content-rows">&nbsp;</td>
			</tr>
			<?php $this->__auto_add_idlist($row->id);?>
			<!-- sub cats list -->
			
			<?php STACKSTATIC::push($row);?>
				<?php while ($item = STACKSTATIC::pop()): $id = $item->id;?>
					<?php $level[$id] = !isset($level[$id]) ? 0 : $level[$id];?>
					<?php 
						if ($items = $this->PRO_GetSubCatsList($id)) {
							for($x=0; $x<count($items); $x++) {
								STACKSTATIC::push($items[$x]);
								$level[$items[$x]->id] = $level[$id]+1;	
							}
						}
					?>	
					<?php if ($item->parent_id):?>
						<?php $subStt=1;?>
						<?php $subRow = $item;?>
						<tr align="right" class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'">
							<td align="center" valign="middle" class="content-rows">
								<input type="checkbox" name="delete[]" value="<?php echo $subRow->id;?>">							</td>
							<td align="center" valign="middle"  class="content-rows">
								<?php echo $subStt++;?>							</td>
							<td align="center" valign="middle" class="content-rows"><a href="index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&amp;function=edit&amp;id=<?php echo $subRow->id;?>" title="Click for edit"><img src="../clients/images/button/edit.gif" border="0" /></a></td>
							<td align="left" valign="middle" class="content-rows"><br /><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Default url:</td>
                <td align="left" valign="top" nowrap="nowrap">&nbsp;<u><?php echo $this->__getRealPath($subRow->parent_id, $subRow->id);?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Rewriting url:</td>
                <td align="left" valign="top" nowrap="nowrap">&nbsp;<u><?php echo $this->__getVirtualPath($subRow->id);?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Page title:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($subRow->pagetitle && strlen($subRow->pagetitle)) ? $subRow->pagetitle : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Meta keyword:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($subRow->metakeyword && strlen($subRow->metakeyword)) ? $subRow->metakeyword : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Meta description:</td>
                <td align="left" valign="top">&nbsp;<u><?php echo ($subRow->metadescription && strlen($subRow->metadescription)) ? $subRow->metadescription : '<span class="ssssss">[not set]</span>';?></u></td>
              </tr>
            </table></td>
							<?php for ($j=0; $j<count($this->keyLangList); $j++):?>
								<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><a href="index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&amp;function=edit&amp;id=<?php echo $subRow->id;?>" title="Click for edit"><?php echo str_repeat('<font color="#FFFFFF">-------</font>', $level[$subRow->id]-1).'&raquo; '.$subRow->{$this->field_NAME[$j]};?></a></td>
							<?php endfor;?>
							<td align="center" valign="middle" class="content-rows">
								<?php $this->__auto_write_textbox_ordering($subRow->id, $subRow->ordering, 'size="2" maxlength="5" style="text-align:center;"');?>							</td>
							<td align="center" valign="middle" class="content-rows">
								<?php echo $this->__auto_write_checkbox('display', $subRow->id, $subRow->display);?>							</td>
							<td width="90" align="center" valign="middle" nowrap="nowrap"  class="content-rows">
				<?php if ($subRow->isdf):?>
				
					<img src="../clients/images/button/star_icons09.gif" align="absmiddle" /> <a href="javascript:set_default(<?php echo $subRow->parent_id;?>, 0);">[clear]</a>
				<?php else:?>
					<input type="button" value="Set Default" onclick="javascript:set_default(<?php echo $subRow->parent_id;?>, <?php echo $subRow->id;?>);" />
				<?php endif;?>			</td>
						</tr>
						<?php $this->__auto_add_idlist($subRow->id);?>
					<?php endif;?>	
				<?php endwhile;?>
			<!-- end of subs cat list -->
		<?php endfor;?>
		<!-- end of main cats list -->
	</table>
	<?php echo $this->__auto_write_idlist();?>
	<input type="hidden" name="set_default_value" value="set_default_value" id="set_default_value" />
</form>
<br /><div style="width:100%" align="center"><?php print ($_pagelist);?></div><br />

<script type="text/javascript" language="javascript">
function set_display()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=set_display';
	f.submit();
	return;
}
function set_ordering()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=set_ordering';
	f.submit();
	return;
}

function set_default(p1, p2)
{
	document.getElementById('set_default_value').value = p1 + ',' + p2;
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo PRO_CAT_MODULE_NAME;?>&function=set_default';
	f.submit();
	return;
}
</script>
