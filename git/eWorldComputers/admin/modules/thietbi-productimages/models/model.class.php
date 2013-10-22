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
	
	//get data to views
	public static function getDataForViews(&$db, &$where, &$limit)
	{
		$sql = "SELECT * 
				FROM `".TABLE_NAME."` 
				{$where}
				ORDER BY 
						`ordering`,
						`id`
				LIMIT {$limit[0]}, {$limit[1]}"; 
		MODEL::doQuery($sql, $db);
		
		return $db->numRows() ? $db->fetchRowSet() : NULL;
	}
	//end function	
	
	//query
	public static function doQuery($sql, &$db)
	{
		$db->query($sql);
	}
	//end function
		
	public static function doInsert(&$db, &$product_id, &$image)
	{
		$sql = "INSERT INTO `".TABLE_NAME."` 
				(
					`id`,
					`product_id`,
					`image`,
					`ordering`,
					`display`,
					`alt`
				) 
				VALUES 
				(
					NULL, 
					{$product_id}, 
					'{$image}', 
					0, 
					1,
					'".IO::getPOST('alt')."'
				)";
				
		MODEL::doQuery($sql, $db);	
	}
	//end function
	
	public static function doDelete(&$db, &$idList)
	{
		//delete images list
		if (ALLOW_DELETE_IMAGE_SOURCE_WHEN_DELETE_RECORD)
		{
			MODEL::doQuery("SELECT `image` FROM `".TABLE_NAME."` WHERE `id` IN {$idList}", $db);
			if ($db->numRows()) 
			{
				while ($r = $db->fetchRow()) 
				{
					@unlink ('../'.$r->image);
				}
			}
		}
		
		//delete records
		MODEL::doQuery("DELETE FROM `".TABLE_NAME."` WHERE `id` IN {$idList}", $db);
	}
	//end function
	
	public static function autoCreateTables(&$db)
	{
		MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
							`id` int(11) unsigned NOT NULL auto_increment,
							  `product_id` int(11) unsigned default '0',
							  `image` varchar(100) collate utf8_unicode_ci default NULL,
							  `ordering` int(11) unsigned NOT NULL default '0',
							  `display` tinyint(1) unsigned NOT NULL default '1',
							  PRIMARY KEY  (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
						", $db);
	}
	
}
//end class

?>