<?php
defined('IN_SYSTEM') or die('<hr>');
?>
<style type="text/css">
<!--
.ssssss {color: #FF0000}
.wqewqeqwe {
	color: #FF0000;
	font-size: 14px;
	font-weight: bold;
}
.xxxxxxxxxxxxx {
	color: #FF5FAA;
	font-style: italic;
	font-size:11px;
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
				<td><a class="toolbar" href="index.php?module=<?php echo MODULE_CAT_NAME;?>" ><img src="../clients/images/back.png" align="middle" border="0" /><br />Back</a></td>
						<td>&nbsp;</td><td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo MODULE_NAME;?>&function=insert&cat_id=<?php echo $cat_id?>'" >
								<img src="../clients/images/addnew.png" align="middle" border="0" /><br />New</a>
				  </td>
						<td>&nbsp;</td>
						<td>
							<a class="toolbar" href="javascript:checkdelete('Delete selected items ?','Please choose item!')">
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
		<td align="right" valign="middle">Category: <?php echo $cat_selection?>&nbsp;</td>		
	</tr>		
</table>
<?php $idlist = '0';?>
<form method="POST" name="form" id="form" action="index.php?module=<?php echo MODULE_NAME;?>&function=delete" style="margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
  <!--DWLayoutTable-->	
	 <tr valign="center">  	
	   <th align="center" valign="top" nowrap="nowrap"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th align="center" valign="top" nowrap="nowrap">No.</th>
			<th align="left" valign="top" nowrap="nowrap" >Configuration Settings</th>
			<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
			<th align="left" valign="top" nowrap="nowrap" >Name (<span class="ssssss"><?php echo strtoupper($this->keyLangList[$i]);?></span>)</th>
			<?php endfor;?>
			<th align="center" valign="top" nowrap="nowrap" >SKU</th>
			<?php if (USE_PRICE):?>
				<th align="center" valign="top" nowrap="nowrap">Price</th>
			<?php endif;?>
			<?php if (USE_PARTICULAR):?>
				<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
					<th align="left" valign="top" nowrap="nowrap" title="<?php echo $this->descriptionLangList[$i];?>">Particular (<span class="ssssss"><?php echo strtoupper($this->keyLangList[$i]);?></span>)</th>
				    <?php endfor;?>
			<?php endif;?>
			<th align="center" valign="top" nowrap="nowrap">Image</th>
			<?php if (USE_IMAGES_LIST_DETAIL):?><th align="center" valign="top" nowrap="nowrap">Detail Images</th><?php endif;?>
			
			
			<th align="right" valign="top" nowrap="nowrap" width="80">Display <img src="../clients/images/icons/filesave.png" alt="Update" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>
			<th align="center" valign="top" nowrap="nowrap">Sort <img src="../clients/images/icons/filesave.png" alt="Update" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th>			  
			<th nowrap="nowrap">Edit</th>
	</tr> 
		<?php for($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<tr class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'" <?php echo !$row->display ? 'style="background:#B0AC9F";' : NULL;?>>
		  <td align="center" valign="middle" nowrap="nowrap" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id;?>"></td>
			<td align="center" nowrap="nowrap" class="content-rows"><?php echo $stt++;?></td>
			<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="left" valign="top" nowrap="nowrap" class="xxxxxxxxxxxxx">Default url:</td>
                <td align="left" valign="top" nowrap="nowrap">&nbsp;<u><?php echo $this->__getRealPath($row->id);?></u></td>
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
            </table>			  
		</td>
			<?php for ($j=0; $j<count($this->keyLangList); $j++):?>
			<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id;?>" ><?php echo $row->{$this->field_NAME[$j]};?></a></td>
			<?php endfor;?>
			<td align="center" valign="middle" nowrap="nowrap" class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id;?>" ><?php echo $row->code;?></a></td>
			<?php for ($j=0; $j<count($this->keyLangList); $j++):?><?php endfor;?>
			<?php if (USE_PRICE):?>
				<td align="center" valign="middle" class="content-rows"><?php echo $row->price;?></td>
			<?php endif;?>
			<?php if (USE_PARTICULAR):?>
				<?php for ($j=0; $j<count($this->keyLangList); $j++):?>
					<td align="left" valign="middle" class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id;?>" ><?php echo $row->{$this->field_PARTICULAR[$j]};?></a></td>
				<?php endfor;?>
			<?php endif;?>
			<td align="center" valign="middle" class="content-rows"><img src="<?php echo '../'.$row->image;?>" border="0" align="top" title="<?php echo $row->alt;?>"/><br /><span class="alt"><?php echo $row->alt;?></span></td>
			<?php if (USE_IMAGES_LIST_DETAIL):?>
		  <td align="center" valign="middle" nowrap="nowrap"  class="content-rows">[<span class="wqewqeqwe"><?php echo $this->PRO_getCountImagesList($row->id);?></span>]<br />
			<a href="index.php?module=<?php echo MODULE_IMAGES_NAME;?>&product_id=<?php echo $row->id;?>" >Update</a></td>
			<?php endif;?>
			
			<td align="center" valign="middle" class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td>			
			<td align="center" valign="middle" nowrap="nowrap" class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering);?></td>
			<td align="center" valign="middle" nowrap="nowrap" class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id;?>" title="Click for edit"><img src="../clients/images/button/edit.gif" border="0" /></a></td>			
	      <?php $this->__auto_add_idlist($row->id); endfor;?>
</table>
<?php echo $this->__auto_write_idlist();?>
</form>
<br />
<div style="width:100%" align="center"><?php print ($pagelist);?></div><br />

<script type="text/javascript" language="javascript">
function set_display()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_display';
	f.submit();
	return;
}
function set_new()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_new';
	f.submit();
	return;
}
function set_spbanchay()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_spbanchay';
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
function delete_image(url)
{
	if(confirm('Có chắc chắn xoá hình ảnh sản phẩm này không?')){
		window.location.href = url;
	}
	
	return;
}
</script>