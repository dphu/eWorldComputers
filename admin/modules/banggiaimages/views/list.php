<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
						<?php if (ALB):?><td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo $this->moduleCat;?>'" ><img src="../clients/images/cancel.png" name="b" align="middle" border="0" /><br />&laquo; Back</a></td><td>&nbsp;</td><?php endif;?><td><a class="toolbar" href="javascript:window.location.href='index.php?module=<?php echo $this->module;?>&function=insert&catid=<?php echo $cat_id;?>'" >
								<img src="../clients/images/addnew.png" align="middle" border="0" /><br />Add</a>
						</td>
						<td>&nbsp;</td>
						<td>
							<a class="toolbar" href="javascript:checkdelete('Delete selected items ?','Please chose item')" >
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
		<img src="../clients/icons/editor.gif" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;">
		<p class="content-caption" style="padding-top:15px; padding-left:70px;"><?php echo $this->title;?></p>
		</td>
		<td align="right" valign="middle">&nbsp;
	    </td>		
	</tr>		
</table>
<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo $this->module;?>&function=delete" name="form" id="form"  style="margin:0">
<table width="100%" cellspacing="0" border="0"cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
  <!--DWLayoutTable-->	
	 <tr valign="center">  	
	   <th width="34" height="20" align="center" valign="middle"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th width="52" align="center" valign="middle">No.</th>
			<th width="350"  align="left" valign="middle" nowrap="nowrap" >&nbsp;File name</th>
			<th width="350"  align="left" valign="middle" nowrap="nowrap" >&nbsp;Title&nbsp;&nbsp;[<a href="javascript:set_title();">save changed titles </a>]</th>
			<th width="150"  align="center" valign="middle" nowrap="nowrap" >Allow download &nbsp;&nbsp;<img src="../clients/images/icons/filesave.png" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>		
		  
		    <th width="150"  align="center" valign="middle" nowrap="nowrap" >Sort&nbsp;&nbsp; <img src="../clients/images/icons/filesave.png"  width="16" height="16" style="cursor:pointer;" onclick="javascript:set_ordering();" /></th> 
    </tr> 
		<?php while($found && $row = $this->db->fetchRow()):?>
		<tr class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'">
		  <td align="center" class="content-rows"><input type="checkbox" name="delete[]" value="<?php echo $row->id?>"></td>
			<td align="center" class="content-rows"><?php echo $stt++?></td>
			<td align="left" valign="middle" class="content-rows"><a href="<?php echo $this->dirpath.$row->filename;?>" target="_blank"><?php echo $row->filename;?></a></td>
			<td align="left" valign="middle" class="content-rows">&nbsp;
		    <?php $this->__auto_write_textbox_ordering($row->id, $row->title, 'style="width:300px;"', 'title')?></td>
			<td align="center"  valign="middle"  class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display)?></td>			
			<td align="center" valign="middle"  class="content-rows"><?php $this->__auto_write_textbox_ordering($row->id, $row->ordering)?></td> 
		  <!-- <td class="content-rows"></td> -->
		  <?php $this->__auto_add_idlist($row->id); endwhile;?>
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
function set_title(){
	var f = document.getElementById('form');
	f.action= 'index.php?module=<?php echo $this->module;?>&function=set_title';
	f.submit();
	return;
}
</script>