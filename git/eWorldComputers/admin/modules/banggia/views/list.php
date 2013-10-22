<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};
?>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo $this->module;?>&function=insert'" title="Thêm mới">
								<img src="../clients/images/addnew.png" alt="Thêm mới" name="new" title="Thêm mới" align="middle" border="0" />				<br />Mới</a>
						</td>
						<?php if (count($rows)):?>
						<td>&nbsp;</td>
						<td>
							<a class="toolbar" href="javascript: checkdelete('Bạn muốn xóa mẫu tin này không?','Xin vui lòng chọn mẫu tin để xóa!')" title="Xóa mẫu tin">
							<img src="../clients/images/delete.png"  alt="Xóa" name="remove" title="Xóa mẫu tin" align="middle" border="0" />				<br />Xóa</a>
						</td>	
					<?php endif;?>		
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
		<td align="right" valign="middle">&nbsp;</td>		
	</tr>		
</table>
<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo $this->module;?>&function=delete" name="form" id="form"  style="margin:0">
<table cellspacing="0"  border="0"cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist" width="auto">
  <!--DWLayoutTable-->	
	 <tr valign="center">  	
	   <th height="20" align="center" valign="middle"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th align="center" valign="middle">STT</th>
			<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
				<th align="left" valign="middle" nowrap="nowrap" >Tiêu đề <font color="#FF0000">(<span title="<?php echo $this->descriptionLangList[$i];?>"><?php echo strtoupper($this->keyLangList[$i]);?></span>)</font></th>
			<?php endfor;?>
			<th  align="left" valign="middle" nowrap="nowrap" >File đính kèm</th>
			<th width="80"  align="center" valign="middle" nowrap="nowrap" >Show&nbsp;<img src="../clients/images/icons/filesave.png" alt="Cập nhật thuộc tính hiển thị" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>		
		  
		    <th width="80"  align="center" valign="middle" nowrap="nowrap" >Order <img src="../clients/images/icons/filesave.png" alt="Cập vị trí" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th> 
		    <th align="center" valign="middle" nowrap="nowrap" >Edit </th>
    </tr> 
		<?php for ($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<tr class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'">
		  <td align="center" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id?>"></td>
			<td align="center" class="content-rows" style="border-left:1px solid #eeeeee;"><?php echo $stt++?></td>
			<?php for ($j=0; $j<count($this->keyLangList); $j++):?><td  align="left"  class="content-rows"><?php echo $row->{$this->field_TITLE[$j]};?></td>
			<?php endfor;?>
			<td  align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php $this->__writeLinkToFile($row->id);?></td>
			<td align="center"  valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td>			
			<td align="center" valign="middle"  class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering)?></td> 
			<td align="center" valign="middle"  class="content-rows"><a href="index.php?module=<?php echo $this->module;?>&function=edit&id=<?php echo $row->id?>" title="Sửa nội dung"><img src="../clients/images/button/edit.gif" border="0" /></a></td>
		  <!-- <td class="content-rows"></td> -->
		  <?php $this->__auto_add_idlist($row->id); endfor;?>
</table>
	<?php echo $this->__auto_write_idlist()?>
</form>
<br />
<div style="width:100%" align="center"><?php print ($pagelist);?></div>
<br />

<script type="text/javascript" language="javascript">
function set_display(){
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo $this->module;?>&function=set_display';
	f.submit();
	return;
}
function set_ordering(){
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo $this->module;?>&function=set_ordering';
	f.submit();
	return;
}
</script>