<?php 
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}

require_once 'models/model.class.php';
require_once 'configs/config.cfg.php';

class config extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title = 'Site Config';
	
	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	
	//////////////////
	public function __construct(&$db)
	{
		$this->db = $db;
		
		$this->path[] = '<a href="?">Administrator</a>';
        $this->path[] = '<strong>Config</strong>';
		
		MODEL::autoCreateTables($this->db);
	
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
	}
	
	////////////////////
	private function __write_form_timeout()
	{
		$minutes = $this->__get_config_value('timeout', 30);
		
		$select = '<select name="timeout" id="timeout" class="content-rows">';
		for($i=0; $i<=120; $i++){
			$text = ($i) ? $i.' min' : '-- Unlimited --';
			if($i != $minutes)
				$select .= '<option value="'.$i.'">'.$text.'</option>';
			else
				$select .= '<option value="'.$i.'" selected="selected" >'.$text.'</option>';
		}
		$select .= '</select>';	
				
		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Times auto logout config
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Change value:&nbsp;</td>
										<td height="30" align="left" valign="middle" >'.$select.'</td>
									</tr>
								</table>';
								
		print ($s);						
								
      
	}
	
	////////////////////
	private function __write_form_mail_SMTP()
	{
		#get server mail
		$server_SMTP = IO::formatOutput($this->__get_config_value('server_SMTP'));		
	
		#get mail username
		$user_SMTP = IO::formatOutput($this->__get_config_value('user_SMTP'));		
	
		#get password 
		$pass_SMTP = IO::formatOutput($this->__get_config_value('pass_SMTP'));		

		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Mail SMTP method config
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Server name:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="server_SMTP" type="textbox" value="'.$server_SMTP.'" style="width:650px; height:18px;"></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >User name:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="user_SMTP" type="textbox" value="'.$user_SMTP.'" style="width:650px; height:18px;"></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Password:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="pass_SMTP" type="password" value="'.$pass_SMTP.'" style="width:650px; height:18px;"></td>
									</tr>
								</table>';
      
	   print ($s);
	  
	}
	
	////////////////////
	private function __write_form_mail_contact(){
		#get mail contact
		$admin_mail = IO::formatOutput($this->__get_config_value('admin_mail'));
	
		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Receiver email address
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Email :&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="admin_mail" type="textbox" value="'.$admin_mail.'" style="width:650px; height:18px;"></td>
									</tr>
								</table>';
      
	  print ($s);
	  
	}
	
	
	////////////////////
	function __write_form_type_of_sendmail()
	{
		$typesendmail = IO::formatOutput($this->__get_config_value('typesendmail', 'mail'));
		
		if (!in_array($typesendmail, array('mail', 'smtp', 'remote', 'swift'))) $typesendmail = 'mail';
		
		$selected = array(
							'mail'		=>	'',
							'smtp'		=>	'',
						 );
		$selected[$typesendmail] = ' selected="selected" ';
		
		$select =  '<select name="typesendmail" id="typesendmail" style="width:650px;"> 
  						<option value="mail" '.$selected['mail'].'>By Normal Method</option>
						<option value="smtp" '.$selected['smtp'].'>By SMTP Method</option>
					</select>';
		
		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Send method config
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Select one:&nbsp;</td>
										<td height="30" align="left" valign="middle" >'.$select.'</td>
									</tr>
								</table>';

		 print ($s);					
	}
	
	////////////////////
	function __write_form_remote_file_sendmail(){
		#get remote_file_contact
		$remote_file = IO::formatOutput($this->__get_config_value('remote_file_sendmail'));

		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Remote File Send Mail Config
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Remote File URL:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="remote_file_sendmail" type="textbox" value="'.$remote_file.'" style="width:650px; height:18px;"></td>
									</tr>
								</table>';
       print ($s);
	  
	}
	
	////////////////////
	function __write_form_site_title(){
		#get remote_file_contact
		$title = IO::formatOutput($this->__get_config_value('title'));

		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Site title default
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >Title:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="title" type="textbox" value="'.$title.'" style="width:650px; height:18px;"></td>
									</tr>
								</table>';
       print ($s);
	  
	}
	
	////////////////////
	function __write_meta_head(){
		$meta = IO::formatOutput($this->__get_config_value('meta'));
		$metad = IO::formatOutput($this->__get_config_value('metad'));
	
		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;Meta keywords and descriptions default
										</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="top" nowrap="nowrap" class="text_view_1">Keywords:&nbsp;</td>
										<td height="30" align="left" valign="top" ><textarea name="meta" rows="15" style="width:650px;">'.$meta.'</textarea></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="top" nowrap="nowrap" class="text_view_1">Descriptions:&nbsp;</td>
										<td height="30" align="left" valign="top" ><textarea name="metad" rows="15" style="width:650px;">'.$metad.'</textarea></td>
									</tr>
								</table>';
			print $s;								
    }
	///////////////////////
	
	////////////////////
	private function __write_form_LOGO()
	{
		$THUMBNAIL_WIDTH = IO::formatOutput($this->__get_config_value('THUMBNAIL_WIDTH'));		
		$COLS = IO::formatOutput($this->__get_config_value('COLS'));		
	
		$s = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:#CCCCCC solid .5pt;">
									<tr>
										<td height="23" colspan="2" align="left" valign="middle" nowrap="nowrap" bgcolor="#e7e7e7" class="content-head">
											&nbsp;</td>
									</tr>
									<tr>
										<td width="129" height="5" align="right" valign="middle" nowrap="nowrap" class="form-label" ></td>
										<td width="824" height="5" align="left" valign="middle" ></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="THUMBNAIL_WIDTH" type="textbox" value="'.$THUMBNAIL_WIDTH.'" style="width:50px; height:18px;"></td>
									</tr>
									<tr>
										<td height="30" align="right" valign="middle" nowrap="nowrap" class="text_view_1" >:&nbsp;</td>
										<td height="30" align="left" valign="middle" ><input name="COLS" type="textbox" value="'.$COLS.'" style="width:50px; height:18px;"></td>
									</tr>
								</table>';
      
	   print ($s);
	  
	}
	
	////////////
	function main()
	{
		//check submit
		if($_SERVER['REQUEST_METHOD'] == 'POST' && is_array($_POST))
		{
			//luu cac thong so cau hinh ^-^
			foreach ($_POST as $key => $value) {
				$this->__set_config_value($key, $value);
			}
			
			//OK
			ERROR::msgBox('Updated.');
			IO::redirect('index.php');
		}
				
		///////////////////////////////  SHOW FORM ///////////////////////////////
		require_once 'views/main.php';
	}//end function
	
} //end of class
?>