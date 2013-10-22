<?php defined('IN_SYSTEM') or die('<hr>');?>
<form method="POST" action="" name="form" id="form" style="margin:0">
<table width="100%" class="menubar" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="menudottedline" width="40%">		
		<div class="content-rows"><?php echo implode(' &raquo; ', $this->path)?></div></td>
	<td class="menudottedline" align="right">	
			<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
				<tr valign="middle" align="center">
					<td><a class="toolbar" href="javascript:dosubmit('form');"><img src="../clients/images/save.png" align="middle" border="0" /><br />
					Update</a>
					</td>
					<td>&nbsp;</td>
					<td>
					<a class="toolbar" href="index.php">
						<img src="../clients/images/cpanel.png"  align="middle" border="0" /><br />
						Cancel</a>
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
<table width="100%" border="0" cellspacing="4" cellpadding="5" style="border-bottom:solid #CCCCCC .5pt;border-top:solid #CCCCCC .5pt;border-left: solid #CCCCCC .5pt;border-right:solid #CCCCCC .5pt;">
      <tr>
        <td><?php $this->__write_form_timeout();?></td>
      </tr>
	  <tr>
        <td><?php $this->__write_form_mail_contact();?></td>
      </tr>	
	  <tr>
        <td><?php $this->__write_form_mail_SMTP();?></td>
      </tr>	  
	   <tr>
        <td><?php $this->__write_form_type_of_sendmail();?></td>
      </tr>
	  <tr>
        <td><?php $this->__write_form_site_title();?></td>
      </tr>
	  <tr>
        <td><?php $this->__write_meta_head();?></td>
      </tr>
  </table>
</form>