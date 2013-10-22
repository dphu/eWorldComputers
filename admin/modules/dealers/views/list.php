<?php defined('IN_SYSTEM') or die('<hr>');?>
<style type="text/css">
<!--
.wwew {color: #FF0000}
-->
</style>
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="40%" height="64" nowrap="nowrap" class="menudottedline">
	  <div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
		
	</tr>
</table>

<table class="adminheading"  style="width:100px;" >
	<tr>
		<td width="50" nowrap="nowrap" style="float: left; margin-right: 0px; padding-left:10px; padding-bottom:5px; padding-top:5px;">
	  <img src="../clients/icons/editor.gif" align="middle"></td>
		<td width="60" nowrap="nowrap"><p  class="content-caption"><?php echo $this->title;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
		<td width="50" nowrap="nowrap"><a class="toolbar" href="javascript:window.location.href='?module=<?php echo MODULE_NAME;?>&function=insert'" ><img src="../clients/images/addnew.png" align="middle" border="0" /><br />Add</a>	  </td><td>&nbsp;&nbsp;&nbsp;</td>
							<td width="50" nowrap="nowrap" style="padding-left:10px;"><a class="toolbar" href="javascript:checkdelete('Delete selected items ?','Please choose item!')" ><img src="../clients/images/delete.png"  align="middle" border="0" /><br />Delete</a></td>
	                        <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Country Filter:</strong><select onchange="javascript:doft(this.value);"><option value="all" selected="selected">&nbsp;&nbsp;-- All --&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><option value="in" <?php if(($_SESSION['doft'] == 'in')) echo 'selected="selected"';?>>&nbsp;&nbsp;Only U.S.A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option><option value="out" <?php if(($_SESSION['doft'] == 'out')) echo 'selected="selected"';?>>&nbsp;&nbsp;Outside U.S.A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                              </select>
	                          </td>
	</tr>
</table>

<?php $idlist = '0';?>
<form method="POST" action="index.php?module=<?php echo MODULE_NAME;?>&function=delete" name="form" id="form" style="margin:0"><input name="delid" id="delid" type="hidden" value="" /><input name="doft" id="doft" type="hidden" value="" />
	<table width="100%" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;" class="adminlist">
		<tr valign="center">
		  <th width="15" align="center" valign="middle"><input name="allbox" type="checkbox" id="allbox" onclick="CheckAll(this)"></th>
			<th width="40" align="center" valign="middle" nowrap="nowrap">No.</th>
			<th align="center" valign="middle" nowrap="nowrap" >Action</th>
			
				<th width="100" align="center" valign="middle" nowrap="nowrap" >Display <img src="../clients/images/icons/filesave.png" alt="Cập nhật thuộc tính hiển thị" width="16" height="16" style="cursor:pointer;" onclick="javascript:set_display();" /></th>
				<th align="left" valign="middle" nowrap="nowrap" >Business name</th>
				<th align="left" valign="middle" nowrap="nowrap" >Address</th>
				<th align="left" valign="middle" nowrap="nowrap" >Location</th>
				<th width="80" align="center" valign="middle" nowrap="nowrap" >Zip </th>
				<th width="120" align="left" valign="middle" nowrap="nowrap" >Phone</th>
				<th width="120" align="left" valign="middle" nowrap="nowrap" >Fax</th>
				<th width="120" align="left" valign="middle" nowrap="nowrap" >Email</th>
			 
			    <th width="150" align="left" valign="middle" nowrap="nowrap">Website</th>
			    <?php if(SHOW_LATLON):?><th align="left" valign="middle" nowrap="nowrap">Lat, Lon</th><?php endif;?>
	    </tr>
		<!-- main cats lst -->
		<?php for($i=0; $i<count($rows); $i++)://main cat?>
			<?php $row = $rows[$i];?>
			<?php if($row->display):?><tr align="right" class="content-rows" onmouseover="this.className='content-rows-hover'" onmouseout="this.className='content-rows'"><?php else:?><tr align="right" class="content-rows" style="background:#888888"><?php endif;?>
				<td align="center" valign="middle" class="content-rows">
					<input type="checkbox" name="delete[]" value="<?php echo $row->id?>">				</td>
				<td align="center" valign="middle"  class="content-rows">
					<?php echo $stt++;?>				</td>
				<td width="100" align="center" valign="middle" nowrap="nowrap" class="content-rows" style="color:#000000; font-weight:normal;"><a href="index.php?module=<?php echo MODULE_NAME;?>&function=edit&id=<?php echo $row->id?>" >Edit</a> | <a href="javascript:delone('<?php echo $row->id;?>');" >Delete</a></td>
				
					<td align="center" valign="middle" class="content-rows"><?php echo $this->__auto_write_checkbox('display', $row->id, $row->display);?></td>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $row->Dealer_BusinessName;?></td>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $row->Dealer_Address;?></td>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $this->__getLocation($row->Dealer_Country, $row->Dealer_State, $row->Dealer_City);?></td>
					<td align="center" valign="middle" class="content-rows"><?php echo $row->zip;?></td>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $row->Dealer_Phone;?></td>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $row->Dealer_Fax;?></td>
					<td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $row->Dealer_Email;?></td>
				
				    <td align="left" valign="middle" nowrap="nowrap" class="content-rows"><a href="<?php echo $row->Dealer_WebSite;?>" target="_blank"><?php echo $row->Dealer_WebSite;?></a></td>
				    <?php if(SHOW_LATLON):?><td align="left" valign="middle" nowrap="nowrap" class="content-rows"><?php echo $row->Dealer_Geocode_Latitude;?>, <?php echo $row->Dealer_Geocode_Longitude;?></td><?php endif;?>
		    </tr>
			<?php $this->__auto_add_idlist($row->id);?>
		
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

function delone(id)
{
	if(confirm('Delete this dealer ?'))
	{
		document.getElementById('delid').value = id;
		var f = document.getElementById('form');
		f.action= 'index.php?module=<?php echo MODULE_NAME;?>&function=deleteonce';
		return f.submit();
	}
}

function doft(v)
{
	document.getElementById('doft').value = v;
		var f = document.getElementById('form');
		f.action= 'index.php?module=<?php echo MODULE_NAME;?>';
		return f.submit();
}
</script>
