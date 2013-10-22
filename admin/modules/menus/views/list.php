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
-->
</style>

<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo MODULE_NAME;?>&function=insert'" title="Thêm Danh mục">
								<img src="../clients/images/addnew.png" alt="Thêm Danh mục" name="new" title="Thêm Danh mục" align="middle" border="0" />				<br />Mới</a>
						</td>
						<td>&nbsp;</td>
						<td>
							<a class="toolbar" href="javascript:checkdelete('Bạn muốn xóa mẫu tin này không?','Xin vui lòng chọn mẫu tin để xóa!')" title="Xóa mẫu tin">
							<img src="../clients/images/delete.png"  alt="Xóa" name="remove" title="Xóa mẫu tin" align="middle" border="0" />				<br />Xóa</a>
						</td>	
							
				</tr>
			</table>			
	</td>
</tr>
</table>
<table class="adminheading">
	<tr>
		<td>
		<img src="../clients/icons/editor.gif" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;"><p class="content-caption" style="padding-top:15px; padding-left:70px;"><?php echo $this->title;?></p>		</td>
		<td align="right" valign="middle"> </td>		
	</tr>		
</table>

<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo MODULE_NAME;?>&function=delete" name="form" id="form"  style="margin:0">
<table width="100%" cellspacing="0"  border="0"cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
  <!--DWLayoutTable-->	
	 <tr valign="center">  	
	   <th height="20" align="center" valign="middle"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th align="center" valign="middle">STT</th>
			<?php for ($i=0; $i<count($this->keyLangList); $i++):?>
			<th align="left" valign="middle" nowrap="nowrap" title="<?php echo $this->descriptionLangList[$i];?>" >Tiêu đề (<font color="#FF0000"><?php echo strtoupper($this->keyLangList[$i]);?></font>)</th>
			<?php endfor;?>
			<th  align="center" valign="middle" nowrap="nowrap" >SL Chủ đề </th>
			<th  align="center" valign="middle" nowrap="nowrap" >Hiển thị &nbsp;&nbsp;<img src="../clients/images/icons/filesave.png" alt="Cập nhật thuộc tính hiển thị" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>		
		  
		    <th  align="center" valign="middle" nowrap="nowrap" >Sắp xếp&nbsp;&nbsp; <img src="../clients/images/icons/filesave.png" alt="Cập vị trí" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th> 
		    <th align="center" valign="middle" nowrap="nowrap" >Chỉnh sửa</th>
    </tr> 
		<?php for($i=0; $i<count($rows); $i++): $row = $rows[$i];?>
		<tr>
		  <td align="center" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id?>"></td>
			<td align="center" class="content-rows"><?php echo $stt++?></td>
			<?php for ($j=0; $j<count($this->field_TEXT); $j++):?>
			<td  align="left" class="content-rows"><?php echo $row->{$this->field_TEXT[$j]};?></td>
			<?php endfor;?>
			<td align="center"  valign="middle"  class="content-rows">[<span class="d"><?php echo $this->PRO_GetCountSubCat($row->id);?></span>] - <a href="index.php?module=catnews&menu=<?php echo $row->id?>">chi tiết</a></td>
			<td align="center"  valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td>			
			<td align="center" valign="middle" nowrap="nowrap"  class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering)?></td> 
			<td align="center" valign="middle" nowrap="nowrap"  class="content-rows"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id?>" title="Sửa nội dung"><img src="../clients/images/button/edit.gif" border="0" /></a></td>
		  <!-- <td class="content-rows"></td> -->
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
function set_ordering()
{
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=set_ordering';
	f.submit();
	return;
}
</script>