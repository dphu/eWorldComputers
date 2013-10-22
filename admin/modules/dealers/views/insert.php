<?php defined('IN_SYSTEM') or die('<hr>');?>

<style type="text/css">
<!--
.sdsd {color: #FF0000}
.dsffsdfsdfsdfdf {
	font-size: 12px;
	font-style: italic;
	color: #0000FF;
	font-weight:normal;
}
-->
</style>

<form method="POST" action="" name="form" id="form" style="margin:0">
<!-- ===================================================================================== -->
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="40%" nowrap="nowrap" class="menudottedline">		
	  <div class="content-rows"><a href="?"><?php echo implode(' &raquo; ', $this->path)?></a></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png"  align="middle" border="0" /><br />Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="<?php echo $this->queryString?>">
					<img src="../clients/images/cancel.png"  align="middle" border="0" /><br />Cancel</a>
					</td>			
				</tr>
			</table>			
	  </td>
</tr>
</table>
<!-- ===================================================================================== -->
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
<br />
<table width="100%" cellspacing="0" cellpadding="0" style="border:0;">
  <tr height="30">
  	<td colspan="2" background="../clients/images/background.jpg"></td>
  </tr>	  
	<tr><td height="10" colspan="2"></td></tr>	<tr>
      <td width="150" height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Country: </td>
      <td align="left" valign="middle" style="padding-left:10px;"><table border="0" cellspacing="0" cellpadding="0">
        
        <tr>
          <td><select id="SelectCT" onchange="javascript:setCT(this.value);">
            <option value="USA" selected="selected">&nbsp;&nbsp;USA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
            <option value="">&nbsp;&nbsp;Outside USA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
          </select>          </td>
          <td>&nbsp;</td>
          <td><span id="n0"><em>Country Name: </em></span></td>
          <td><input name="Dealer_Country" id="Dealer_Country" type="text" size="30" value="<?php IO::writeData('Dealer_Country');?>" style="height:20px;"/> <?php ERROR::writeError('Dealer_Country', '*');?></td>
        </tr>
      </table>
      </td>
      </tr>	
	
	<tr id="sr">
      <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">State: </td>
      <td align="left" valign="middle" style="padding-left:10px;"><?php echo $this->__createDropdownListState();?> <font id="dls"></font></td>
    </tr>
	 <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">City:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_City" id="Dealer_City" type="text" size="20" value="<?php IO::writeData('Dealer_City');?>" style="height:20px;"/> <?php ERROR::writeError('Dealer_City', '*');?></td>
  </tr>
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">ZIP Code :</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="zip" id="zip" type="text" size="20" value="<?php IO::writeData('zip');?>" style="height:20px;"/> <?php ERROR::writeError('zip', '*');?></td>
  </tr>
	<tr>
	  <td colspan="2" align="right" valign="middle" class="content-head"><hr /></td>
    </tr>
	
	
    <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Dealer Name:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_BusinessName" id="Dealer_BusinessName" type="text" size="80" value="<?php IO::writeData('Dealer_BusinessName');?>" style="height:20px;"/> 
      <?php ERROR::writeError('Dealer_BusinessName', '*');?></td>
  </tr>
  
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Address:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_Address" id="Dealer_Address" type="text" size="80" value="<?php IO::writeData('Dealer_Address');?>" style="height:20px;"/> 
      <?php ERROR::writeError('Dealer_Address', '*');?></td>
  </tr>
  
 
  
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Email address:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_Email" id="Dealer_Email" type="text" size="80" value="<?php IO::writeData('Dealer_Email');?>" style="height:20px;"/></td>
  </tr>
  
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Phone number:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_Phone" id="Dealer_Phone" type="text" size="80" value="<?php IO::writeData('Dealer_Phone');?>" style="height:20px;"/></td>
  </tr>
  
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Fax number:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_Fax" id="Dealer_Fax" type="text" size="80" value="<?php IO::writeData('Dealer_Fax');?>" style="height:20px;"/></td>
  </tr>
  
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Website:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_WebSite" id="Dealer_WebSite" type="text" size="80" value="<?php IO::writeData('Dealer_WebSite');?>" style="height:20px;"/></td>
  </tr>
  
  
   <tr>
      <td colspan="2" align="right" valign="middle" nowrap="nowrap" class="content-head" ><hr /></td>
    </tr>
	
	<?php if(SHOW_LATLON):?>
	<tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Latitude:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_Geocode_Latitude" id="Dealer_Geocode_Latitude" type="text" size="20" value="<?php IO::writeData('Dealer_Geocode_Latitude');?>" style="height:20px;"/> <img id="i0" src="../images/loading.gif" style="display:none;" /></td>
  </tr>
  
    
  <tr>  
    <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">Longitude:</td>
    <td align="left" valign="middle" style="padding-left:10px;"><input name="Dealer_Geocode_Longitude" id="Dealer_Geocode_Longitude" type="text" size="20" value="<?php IO::writeData('Dealer_Geocode_Longitude');?>" style="height:20px;"/> <img id="i1" src="../images/loading.gif" style="display:none;" /></td>
  </tr>
  
<tr>  
      <td height="25" align="right" valign="middle" nowrap="nowrap" class="content-head">&nbsp;</td>
      <td align="left" valign="middle" style="padding-left:10px;"><a href="javascript:getLL();">Update from Google Map </a></td>
    </tr>
<?php endif;?>	
	 <tr>
			    <td align="right" nowrap="nowrap" style="padding-left:20px;" class="content-head">&nbsp;</td>
			    <td colspan="3" align="left" class="content-head" style="padding-left:20px;" >&nbsp;</td>
    </tr>
   
  <tr height="40" valign="middle">
  	<td></td>  	
	<td align="left"><span style="font-family: tahoma; font-size: 11px;"> (<font color="#FF0000">*</font>) : Is required.</span></td>
  </tr>   
</table>
</form>
<script type="text/javascript" language="javascript">
	function getLL()
	{
		var i0 = document.getElementById('i0');
		var i1 = document.getElementById('i1');
		
		var Dealer_Geocode_Latitude = document.getElementById('Dealer_Geocode_Latitude');
		var Dealer_Geocode_Longitude = document.getElementById('Dealer_Geocode_Longitude');
		
		i0.style.display ='';
		i1.style.display ='';
		
		Dealer_Geocode_Latitude.value = '';
		Dealer_Geocode_Longitude.value = '';
		
		var e = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
	
		if (e) {
			e.onreadystatechange = function()
								{
									if (e.readyState == 4 && e.status == 200) {
										i0.style.display = 'none';
										i1.style.display = 'none';
										
										var s = e.responseText;
										if (s == ',')
										{
											alert("Couldn't received result.\n\nPlease check valid for values : State, City, ZIP Code and Dealer Address");
										}
										else
										{
											var a = s.split(',');
											Dealer_Geocode_Latitude.value = a[0];
											Dealer_Geocode_Longitude.value = a[1];
										}
									}
								}
		
			//values
			var address = document.getElementById('Dealer_Address').value;
			var city = document.getElementById('Dealer_City').value;
			var state = '';
			if (document.getElementById('Dealer_State').style.display == '') //USA
			{
				state = document.getElementById('Dealer_State').value;
			}
			else
			{
				state = document.getElementById('Dealer_Country').value
			}
				
			//params
			var param = '';
			param += 'address='+address;
			param += '&city='+city;
			param += '&state='+state;
			param += '&zip='+document.getElementById('zip').value;
			param += '&<?php echo AJAXSECURITY::GetKey();?>';
			
			//send
			e.open("POST",'getLL.php', true);
			e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			e.send(param);
		}
	}
	
	var Dealer_Country = document.getElementById('Dealer_Country');
	var Dealer_State = document.getElementById('Dealer_State');
	var Dealer_City = document.getElementById('Dealer_City');
	var n0 = document.getElementById('n0');
	var sr = document.getElementById('sr');
		
	function setCT(v)
	{
		Dealer_Country.value = v;	
		Dealer_State.value = '<?php echo IO::getPOST('Dealer_State');?>';
		Dealer_City.value = '<?php echo IO::getPOST('Dealer_City');?>';
				
		if (v == 'USA') //USA
		{
			n0.style.display = 'none';
			Dealer_Country.style.display = 'none';
			sr.style.display = '';
		}
		else
		{
			n0.style.display = '';
			Dealer_Country.style.display = '';
			sr.style.display = 'none';
		
			Dealer_Country.select();
		}
	}
	var __setCTValue = '<?php echo IO::getPOST('Dealer_Country');?>'; 
	Dealer_State.value = '<?php echo IO::getPOST('Dealer_State');?>';
	if (__setCTValue == 'USA')
	{
		document.getElementById('SelectCT').value = __setCTValue;
		Dealer_Country.style.display = 'none';
		n0.style.display = 'none';
		sr.style.display = '';
	}
	else
	{
		document.getElementById('SelectCT').value = '';
		Dealer_Country.style.display = '';
		n0.style.display = '';
		sr.style.display = 'none';
	}
	
	function showStateCode(value)
	{
		var d = document.getElementById('dls');
		var v = '';
		
		if (d)
		{
			if (value == '')
			{
				v = '';
			}
			else
			{
				v = '(' + value + ')';
			}
			
			if (d.innerHTML != v)
			{
				d.innerHTML = v;
			}
		}
	}
	showStateCode('<?php echo IO::getPOST('Dealer_State');?>');
</script>