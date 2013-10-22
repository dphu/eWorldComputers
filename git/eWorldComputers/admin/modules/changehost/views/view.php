<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};?>
<style type="text/css">
<!--
.style1 {
	color: #BB0000;
	font-weight: bold;
	font-size: 36px;
}
-->
</style>


<form method="post" action="" style="width:100%; text-align:center;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="30%" align="center" valign="middle">&nbsp;</td>
      <td align="left" valign="middle"><span class="style1"><br />
CHANGE HOST<br />
      <br />
      </span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">From HOST: </td>
      <td align="left" valign="top"> <input name="host" type="text" id="host" />
        &nbsp;
        <?php echo ERROR::writeError('host', '*');?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><br />
      <input type="submit" name="Submit" value="Submit" />
      <br />
      <br />
      <br /></td>
    </tr>
  </table>
  <label><br />
  <br />
  <br />
  <br />
  <br /><br />
  </label>
  <label> <br />
  </label>
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
</form>