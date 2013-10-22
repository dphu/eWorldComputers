<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}?>
<script type="text/javascript">
	var totalItems = 0;
	var SHOW_FILENAME = <?php echo SHOW_FILENAME ? '1' : '0';?>;
	function __getListInfo()
	{
		totalItems = 0;
		document.getElementById('list').innerHTML = '';
		document.getElementById('loading').style.display = '';
		var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
		if (e) 
		{
			e.onreadystatechange = function()
								{
									if (e.readyState == 4 && e.status == 200) 
									{
										if (e.responseText == 'Invalid')
										{
											alert(e.responseText);
											return;
										}
										__showListInfoImage(e.responseText);
									}
								}
			e.open("POST", 'admingetfilelistattachmentimage.php', true);
			e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			e.send('type=Flash');
		}
	}
	function __showListInfoImage(result)
	{
		var list = new Array();
		list = result.split(String.fromCharCode(10));
		
		result = null;
				
		var itemsCount = list.length;
		var columns = 5;
		var le = (itemsCount % columns) ? 1 : 0;
		var rows = parseInt(itemsCount / columns) + le;
		var o = document.getElementById('list');
		var i = 0;
		var tdWidth = parseInt(100 / columns) + '%';
		
		var td, file, name, dimension, style, src, column, row, HTML, onClick;
		
		HTML = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		
		for (row=0; row < rows; row++)
		{
			HTML += '<tr>';
			for (column=0; column < columns; column++)
			{
				td = '&nbsp;';
				if (i < itemsCount)
				{
					totalItems++;
					var a = new Array();
					a = list[i].split(String.fromCharCode(13)); 
					list[i] = null;
					name = a[0];
					file = a[0];
					dimension = a[1];
					sizeondisplay = a[2];
					a = null;
					src = '<?php echo MYSITEROOT;?>attachment/image/'+file;
					
					var linkDelete = '<a href="javascript:void(0);" onclick="javascript:deletefile(\''+file+'\', \'td_'+i+'\');">delete</a>';
					var linkView = '<a href="<?php echo MYSITEROOT;?>viewflash.php?file='+file+'" target="_blank">view</a>';
					//var linkSelect = '<a href="javascript:OpenFile(\''+src+'\');">select</a>';
					td = '<embed '+sizeondisplay+' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'+src+'" play="true" loop="true" menu="true"></embed><br>('+dimension+')<br>'+linkDelete+'&nbsp;|&nbsp;'+linkView+'<br>&nbsp;';
				}
				HTML += '<td id="td_'+i+'" width="'+tdWidth+'" height="180" align="center" valign="bottom">' + td +'</td>';
				i++;
			}
			HTML += '</tr>';
		}
		
		HTML += '</table>';
		
		list = null;
		
		o.innerHTML = HTML;
		
		document.getElementById('loading').style.display = 'none';
		__setTotal();
	}
	
	function deletefile(name, td)
	{
		if (!confirm('Delete this file ?')) return;
		
		document.getElementById(td).style.verticalAlign = 'middle';
		document.getElementById(td).innerHTML = '<img src="modules/<?php echo $module;?>/images/loading.gif" /><br>deleting...';
		
		var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
		if (e) 
		{
			e.onreadystatechange = function()
								{
									if (e.readyState == 4 && e.status == 200) 
									{
										if (e.responseText == 'OK')
										{
											document.getElementById(td).innerHTML = '&nbsp;';
											totalItems--;
											__setTotal();
										}
									}
								}
			e.open("POST", 'admingetfilelistattachmentimage.php', true);
			e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			e.send('delete='+name);
		}	
	}
	function __setTotal()
	{
		document.getElementById('totalItems').innerHTML = totalItems;
	}
	
	//for popup
	function setSelect(folder, filename)
	{
		var o = window.opener;
		if (o)
		{
			//flag to set
			var flag = o.document.getElementById('<?php echo IO::getKey('flag');?>');
			if (flag)
			{
				if (flag.value == 'yes')
				{
					//img to view demo
					var srcimg = o.document.getElementById('<?php echo IO::getKey('srcimg');?>');
					if (srcimg)
					{
						srcimg.src = folder+filename;
					}
					
					//filename to save DB
					var srcimage = o.document.getElementById('<?php echo IO::getKey('srcimage');?>');
					if (srcimage)
					{
						srcimage.value = filename;
					}
			
					//focus
					o.focus();
				}
			}
		}
		window.close();
	}
	</script>
	<style type="text/css">
<!--
.asadsadsdsadsadsadsadsadsads {
	color: #AA0000;
	font-weight: bold;
	font-size: 18px;
	font-family: Tahoma;
}
.style1 {
	font-size: 12px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
-->
    </style>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="27%" height="50" align="left" valign="middle" nowrap><span class="asadsadsdsadsadsadsadsadsads">&nbsp;&nbsp;&nbsp;<u>FLASHES MANAGER</u> (<font color="#000099">total: </font><font id="totalItems" color="#000099">0</font>)</span></td>
    <td width="64%" align="left" valign="middle" nowrap><form method="post" action="" enctype="multipart/form-data">
      <span class="style1">New Flash: 
      <input name="image" type="file" class="form-field" id="image" size="34"/>
    </span>
      
       <input type="submit" name="Submit" value="Upload to Server">
      <?php ERROR::writeError('image');?>
      <input type="hidden" name="sm" value="sm">
    </form>
    </td>
  </tr>
</table>
	<hr>
<div style="display:none; width:100%; margin-top:100px; text-align:center;" id="loading"><img src="modules/<?php echo $module;?>/images/loading.gif" /><br><br><b>Loading...</b></div>
<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td width="100%" height="300" align="left" valign="top" id="list"></td>
</tr></table>
<script language="javascript" type="text/javascript">__getListInfo();</script>