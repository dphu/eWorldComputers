<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};
?>
<style type="text/css">
<!--
.ww {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #FF0000;
}
.h {
	color:#FF0000;
}
.n {
	color:#000000;
}
.ss {
	color: #000099;
	font-size: 10;
}
.fre {color: #009900; font-size: 10; }
.aaaaaaaaaaaaaaaaaa {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<br />
<?php if ($KHMUABDS != ''):?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" valign="middle" scope="row"><span class="aaaaaaaaaaaaaaaaaa"><?php echo $KHMUABDS;?></span></th>
  </tr>
</table>
<?php endif;?>
<?php if ($KHRV != ''):?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" valign="middle" scope="row"><span class="aaaaaaaaaaaaaaaaaa"><?php echo $KHRV;?></span></th>
  </tr>
</table>
<?php endif;?>
<?php if ($KHBDS != ''):?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" valign="middle" scope="row"><span class="aaaaaaaaaaaaaaaaaa"><?php echo $KHBDS;?></span></th>
  </tr>
</table>
<?php endif;?>
<?php if ($KHFAQ != ''):?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th align="center" valign="middle" scope="row"><span class="aaaaaaaaaaaaaaaaaa"><?php echo $KHFAQ;?></span></th>
  </tr>
</table>
<?php endif;?>
