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
	
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_NAME)
	{
		$field_NAME = array();
		for ($i=0; $i<count($fieldsLangList); $i++) {
			$field_NAME[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
		}
		$field_NAME = $field_NAME[0];
	}
	
	//get data to views
	public static function getDataForViews(&$db, &$where, &$limit)
	{
		$sql = "SELECT * 
				FROM `".TABLE_NAME."`
				{$where}
				ORDER BY `ordering`, `id` 
				LIMIT {$limit[0]} , {$limit[1]}";
		MODEL::doQuery($sql, $db);
		
		return $db->numRows() ? $db->fetchRowSet() : NULL;
	}
	//end function	
	
	//get data to edit
	public static function getDataForEdit(&$db, &$id, &$field_NAME)
	{
		MODEL::doQuery("SELECT `".implode('`, `', $field_NAME)."`, code FROM `".TABLE_NAME."` WHERE `id` = {$id} LIMIT 1", $db);
		
		if ($db->numRows()) {
			foreach ($db->fetchRow() as $key => $value) {
				IO::setPost($key, $value);
			}
			return true; 
		} else {
			return false;
		}
	}
	//end function	
	
	//query
	public static function doQuery($sql, &$db, $debug = FALSE)
	{
		if ($debug) view($sql);
		$db->query($sql);
	}
	//end function
	
	//update
	public static function doUpdate(&$db, &$menu_id, &$fields, &$id)
	{
		$list = '';
		foreach ($fields as $field => $value) {
			$list .= ", `{$field}` = '{$value}'";
		}
		
		return MODEL::doQuery("UPDATE `".TABLE_NAME."` SET `menu_id` = {$menu_id} {$list} WHERE `id` = {$id} LIMIT 1", $db);
	}
	
	public static function doInsert(&$db, &$list, &$menu_id)
	{
		$field = '';
		$value = '';
		foreach ($list as $k => $v) {
			$field .= ", `{$k}`";
			$value .= ", '{$v}'";
		}
		
		$sql = "INSERT INTO `".TABLE_NAME."` 
				(
					`id`,
					`menu_id`
					{$field},
					`ordering` ,
					`display`
				)
				VALUES 
				(
					NULL,
					{$menu_id}
					{$value},
					'0', 
					'1'
				)";  
		return MODEL::doQuery($sql, $db);	
	}
	//end function		
	
	public static function getMenuId(&$db, &$id)
	{
		MODEL::doQuery("SELECT `menu_id` FROM `".TABLE_NAME."` WHERE `id` = {$id} LIMIT 1", $db);		
		if (!$db->numRows()) {
			return 0;
		} else {		
			$row = $db->fetchRow();
			return $row->menu_id;
		}	
	}
	
	###############################################
	public static function doDelete(&$db, &$idList)
	{
		//delete child news
		MODEL::doQuery("DELETE FROM `".TABLE_CHILD_NAME."` WHERE `cat_id` IN {$idList}", $db);
		//delete cat news
		MODEL::doQuery("DELETE FROM `".TABLE_NAME."` WHERE `id` IN {$idList}", $db);
	}
	//end function
	
	####################################
	public static function createDB(&$db)
	{
		MODEL::doQuery("
						CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
						  `id` int(11) unsigned NOT NULL auto_increment,
						  `menu_id` int(11) unsigned NOT NULL default '0',
						  `ordering` int(11) unsigned NOT NULL default '1',
						  `display` tinyint(1) unsigned NOT NULL default '1',
						  PRIMARY KEY  (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
						", $db);
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'name', 'varchar(255)');	
		
		$db->query("ALTER TABLE `".TABLE_NAME."` ADD `istinh` TINYINT(1) UNSIGNED NULL DEFAULT '0'");
		$db->query("ALTER TABLE `".TABLE_NAME."` ADD `isfaq` TINYINT(1) UNSIGNED NULL DEFAULT '0'");
		$db->query("ALTER TABLE `".TABLE_NAME."` ADD `isgallery` TINYINT(1) UNSIGNED NULL DEFAULT '0'");
		$db->query("ALTER TABLE `".TABLE_NAME."` ADD `code` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL");
		
		MODEL::doQuery("
						CREATE TABLE IF NOT EXISTS `".TABLE_CAT_NAME."` (
					  `id` int(11) unsigned NOT NULL auto_increment,
					  `ordering` int(11) NOT NULL default '1',
					  `display` tinyint(1) NOT NULL default '1',
					  `text_en` varchar(50) collate utf8_unicode_ci default NULL,
					  PRIMARY KEY  (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
					", $db);
		if (!__MYMODEL::__doSELECT($db, '*', TABLE_CAT_NAME, NULL, NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			__MYMODEL::__doINSERT($db, TABLE_CAT_NAME, array('`display`', '`text_en`'), array(1, "'USA'"));
		}			

	}
	//end function
	
	#########################
	protected static function PRO_InsertLangConfig(&$db, $table, $field, $type)
	{
		if (!$db->count_records('tbl_config_fields_lang', "LOWER(`table`) = LOWER('{$table}') AND LOWER(`field`) = LOWER('{$field}') AND LOWER(`type`) = LOWER('{$type}')")) {
			MODEL::doQuery("INSERT INTO `tbl_config_fields_lang` (`id`, `table`, `field`, `type`) VALUES (NULL, '{$table}', '{$field}', '{$type}')", $db);
		}
	}
	//end function
	
}
//end class

?>