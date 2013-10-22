<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

class MYCLASS extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	
	//---------------------- constructor ------------------- //
	public function __construct(&$db)
	{
		$this->db = $db;
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (`id` int(11) unsigned NOT NULL auto_increment, `content` longtext collate utf8_unicode_ci, PRIMARY KEY  (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1");
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = '<strong>'.MODULE_DESC.'</strong>';
		$this->title = MODULE_DESC;
		
		//first insert
		if (!$this->db->count_records(TABLE_NAME)) {
			__MYMODEL::__doINSERT($this->db, TABLE_NAME, array('`content`'), array("''"));
		}
	}
	
	//function edit database
	public function edit()
	{
		//save link
		IO::setBackURL();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$content = FCK ? IO::getPOST('content', '', true) : IO::getPOST('content');
			__MYMODEL::__doUPDATE($this->db, TABLE_NAME, array("`content` = '{$content}'"));
			if (defined('EXPORT_TO_FILE'))
			{
				$this->__EXPORT_TO_FILE($content);
			}
			
			return IO::redirect('index.php');
		}

		#get info on DB
		$row = __MYMODEL::__doSELECT($this->db, '*', TABLE_NAME, NULL, NULL, NULL, NULL, 'fetchRow');
		
		#view
		return require 'global/editanydata/editmanager.php';
    }
	//end function
	
	//export to file
	private function __EXPORT_TO_FILE($content)
	{
		if ($fp = fopen(EXPORT_TO_FILE, 'w'))
		{
			fwrite($fp, ((defined('EXPORT_TO_FILE_AUTO_FIX') && (EXPORT_TO_FILE_AUTO_FIX === TRUE)) ? stripcslashes($content) : $content));
			fclose($fp);
		}
	}
	//end function
}
//end class

?>