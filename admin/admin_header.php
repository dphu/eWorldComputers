<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<style type="text/css">
	<!--
	.alt
	{
	background:#FFFFCC;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#007700;
	font-style:italic;
	}
	input, text {
		height:20px;
	}
	.ssssss {color: #FF0000}
	.xxxxxxxxxxxxx {
	color: #FF5FAA;
	font-style: italic;
	font-size:11px;
}
.dsffsdfsdfsdfdf {
	font-size: 12px;
	font-style: italic;
	color: #0000FF;
	font-weight:normal;
}
	-->
	</style>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>..:: Administrator Control Panel ::..</title>
		<link href="../clients/css/admin.css" media="all" rel="stylesheet"  type="text/css" />		
		<link rel="stylesheet" href="../clients/css/theme.css" type="text/css" />
		<link rel="stylesheet" href="../clients/css/template_css.css" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="../clients/css/page.css">
		<link rel="stylesheet" type="text/css" href="../clients/css/admin.css">
		<script language="JavaScript" src="../clients/javascript/JSCookMenu.js" type="text/javascript"></script>
		<script language="JavaScript" src="../clients/javascript/theme.js" type="text/javascript"></script>
        <script language="javascript" type="text/javascript" src="../clients/javascript/check_functions.js"></script>
        <script language="javascript" type="text/javascript" src="../clients/javascript/function.js"></script>
        <script language="javascript" type="text/javascript" src="../clients/javascript/calendar.js"></script>
		<script language="javascript" type="text/javascript">
			function opp(url, name, width, height){
				window.open (url, name, "toolbars=no, resizeable=no, menus=no, width="+width+", height="+height+",scrollbars=yes");
			}

			function openWindow(url, name){
				window.open (url, name, "toolbars=no, resizeable=no, menus=no, width=600, height=300,scrollbars=no");
			}
		</script>
        <script language="javascript">
        function CheckAll(parent){
            var ids = document.getElementsByTagName('input');

            for(var i=0; i<ids.length; i++){
                if(ids[i].name == "delete[]"){
                    ids[i].checked = parent.checked;
                }
            }
        }		
		function candel()
		{
			if (!check_selected()) {
				return true;
			}
			
			var elms=document.form.elements;
			for (i = 0; i < elms.length; i++) {
				if (elms[i].name == 'delete[]') {
					if (!elms[i].checked) {
						return true;
					}
				}
			}	
			
			alert('Can not delete all!');
			
			return false;			
		}
		function check_selected()
		{
			var elms=document.form.elements;
			if (!elms){
			return false;
			}
			ok = false;
			for (i = 0; i < elms.length; i++) 	{
				if (elms[i].name == 'delete[]') {
					if (elms[i].checked == true){
						ok = true;
						break;
					}
				}
			}
			return ok;
		}
		function checkdelete(ques,warn)
		{
			if (check_selected())
			{
				if (confirm(ques))
				{
					window.document.form.submit();
					return true;
				}
				return ;
			}
			alert(warn);
			return ;
		}
        function jumpMenu(targ, selObj, url){ //v3.0
            if(selObj.selectedIndex == 0){
                window.location = url;
                return;
            }

            eval(targ+".location='" + url + selObj.options[selObj.selectedIndex].value + "'");
        }
		
		function dosubmit(f)
		{
			var f = document.getElementById(f);
			if (f) {
				f.submit();
			} else {
				return window.document.forms.f.submit();
			}
			return;
		}
        </script>
		<script language="JavaScript" type="text/javascript">
			function $(m, i, p)
			{
				var d=document.getElementById(i);
				d.innerHTML='';
				if(document.getElementById)
					var e=window.ActiveXObject?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest();
				if(e){
					e.onreadystatechange=function(){
						d.innerHTML='';
						if(e.readyState==4&&e.status==200){
							d.innerHTML=e.responseText;
						}
					};
					e.open("POST",'aj.php',true);
					e.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					e.send('sid=<?php echo md5(session_id());?>&mid='+m+'&'+p);
				}
			}
		</script>
	</head>
<body bgcolor="#006699"><div id="mainbody" style="display:table; width:100%; height:100%;">
		<DIV id="dek"></DIV>
        <script language="javascript" type="text/javascript" src="../clients/javascript/dis-preview_image.js"></script>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="wrapper">
		<tr>
			<td colspan="3" id="banner">
				<table width="100%" border="0" cellspacing="8" cellpadding="0">
					<tr>
						<td height="*" align="center" valign="middle"><a href="index.php"><img src="logo/eworldbanner.jpg" width="260" height="75" alt="logo" /></a></td>
						<td width="79%" align="center" class="top_title1">CONTENT MANAGEMENT SYSTEM</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if (!$isPopup):?>
		<tr>
			<td colspan="3" id="nav">
				<ul id="nav-item">
					<li id="nav-item-left">Today, <?php echo gmdate('d-m-Y',time())?></li>
					<?php if (!(strtolower($module)=='files_vbpl' && strtolower($function)=='showlist') && !(strtolower($module)=='files_tuyendung' && strtolower($function)=='showlist')){?>
					<li id="nav-item-right">Loged in as: <?php echo $_SESSION['username']?> | <a href="?module=account">Change Account</a> | <a href="?module=logout">Log out</a></li>
					<?php }?>
				</ul>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<?php if (!(strtolower($module)=='files_vbpl' && strtolower($function)=='showlist') && !(strtolower($module)=='files_tuyendung' && strtolower($function)=='showlist') && !(strtolower($module)=='files_vlxd' && strtolower($function)=='showlist')){?>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td class="menubackgr" style="padding-left:5px;">
							<div id="myMenuID"></div>
							<script language="JavaScript" type="text/javascript">
								function b(s){return '<b><font color="#FF0000">'+s+'</font></b>';}
								var myMenu =
								[
									<?php SMN();?>
								
									[null,'[System]',null,null,'',
										['','Site Config','index.php?module=config',null,''],
										['','Javascript Code Manager','index.php?module=ajax_manager',null,''],
										/*_cmSplit,
										['','Change Host','index.php?module=changehost',null,''],*/
									],
									
									[null,'[Contents]',null,null,'',
										['','Images Manager','index.php?module=imagesmanager',null,''],
										_cmSplit,
										['','Flashes Manager','index.php?module=flashesmanager',null,''],
									],
									
									[null,'[Header & Footer]',null,null,'',
										['','Header Menu','index.php?module=block&function=edit&id=210',null,''],
										['','Footer Menu','index.php?module=block&function=edit&id=2',null,''],
									],
									
									[null,'[Pages Manager]',null,null,'',
										/*['','Homepage','index.php?module=edit_template&title=___ADMIN_EDITOR___HOMEPAGE',null,''],
										_cmSplit,*/
										['','Categories & Products' + b('►'),null,null,'',
											['','Category Manager','changecategory.html',null,''],
											['','Products Manager','change-products',null,''],
										],
										_cmSplit,
										/*['','Product Information','index.php?module=block&function=edit&id=221',null,''], */
										['',' Single Pages' + b('►'),null,null,'', 
											['','About Us','index.php?module=block&function=edit&id=220',null,''],
											['','How we can help','index.php?module=block&function=edit&id=221',null,''],
											['','Our Location','index.php?module=block&function=edit&id=224',null,''],
											['','Contact Us','index.php?module=block&function=edit&id=226',null,''],
											['','Privacy Policy','index.php?module=block&function=edit&id=222',null,''],
										],
										/*['','Catalog Request','index.php?module=block&function=edit&id=224',null,''],
										['','Store Locator ' + b('►'),null,null,'',
											['','Page Manager','index.php?module=block&function=edit&id=229',null,''],
											_cmSplit,
											['','Dealers Manager','index.php?module=dealers',null,''],
										],
										
										_cmSplit,
										['','About Us','index.php?module=block&function=edit&id=220',null,''],
										['','Product Registration','index.php?module=block&function=edit&id=228',null,''],
										
										['','Download ' + b('►'),null,null,'',
											['','Page Manager','index.php?module=block&function=edit&id=5000',null,''],
											_cmSplit,
											['','Documents Manager','index.php?module=banggiaimages&catid=6',null,''],
										], */
										
									/*	['','Privacy Policy','index.php?module=block&function=edit&id=222',null,''],
										_cmSplit,
									/*	['','Contact Us','index.php?module=block&function=edit&id=226',null,''], */
										/*['','Join email','index.php?module=block&function=edit&id=227',null,''],*/
									],

								];
								cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
								</script>
							</td>		
						</tr>
				</table>
				<?php }?>
			</td>
		</tr>
		<?php endif;?>
		<tr>
    		<td height="8" background="../clients/for_admin_login/rightpanel_tbl_b.gif" bgcolor="#F5F5F6" style="background-repeat: repeat-x;" colspan="3">
			</td>
		</tr>
		<tr>
			<td  colspan="3" width="100%" id="right-column" bgcolor="#F5F5F6">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100%" valign="top" style="border: 1px solid #CCCCCC; background: #FFFFFF;">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="100%" valign="top"><?php require_once 'modules/'.$module.'/index.php';?></td>
                      </tr>
                    </table>
				</td>
				<td width="40" valign="top" background="../clients/for_admin_login/rightpanel_tbl_mr.gif"><img src="../clients/for_admin_login/rightpanel_tbl_mr0.gif">
				</td>
            </tr>
            <tr>
				<td height="9" valign="top" background="../clients/for_admin_login/rightpanel_tbl_b.gif"><img src="../clients/for_admin_login/rightpanel_tbl_b0.gif"></td>
				<td valign="top"><img src="../clients/for_admin_login/rightpanel_tbl_br.gif"></td>
            </tr>
       </table>
     </td>
</tr>
<?php if (!$isPopup):?>
<tr>
	<td colspan="3" id="copyright">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bottom_bar">
				<tr>
					<td height="10" align="left" valign="middle" class="top_copyright">EworldComputer.com</td>
				</tr>
		</table>
	</td>
</tr>
<?php endif;?>
</table>
	</div></body></html>