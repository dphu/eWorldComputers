<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

class MODEL
{
	//cons
	public function __construct()
	{
		//null
	}
	
	//dest
	public function __destruct()
	{
		//null
	}
	
	public static function autoCreateTables(&$db)
	{
		$db->query('
						CREATE TABLE IF NOT EXISTS `'.TABLE_NAME.'` (
						  `id` int(11) unsigned NOT NULL auto_increment,
						  `config_name` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
						  `config_value` longtext character set utf8 collate utf8_unicode_ci,
						  PRIMARY KEY  (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1
					', $db);
	}
	
}
//end class

?>