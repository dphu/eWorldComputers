<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}

class MODEL
{
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_DESC)
	{
		$field_DESC = array();
		for ($i=0; $i<count($fieldsLangList); $i++) {
			$field_DESC[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
		}
		$field_DESC = $field_DESC[0];
	}
	
		
	//query
	public static function doQuery($sql, &$db)
	{
		return __MYMODEL::__doQuery($sql, $db);
	}
	//end function
		
	public static function doInsert(&$db, &$fields, &$values)
	{
		//$sql = 'INSERT INTO `'.TABLE_NAME.'` ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';
		
		$sql = "INSERT INTO `tbl_interface_manager` (".implode(', ', $fields).") VALUES (".implode(', ', $values).")";

		return MODEL::doQuery($sql, $db);
	}
	//end function		
	
	public static function doUpdate(&$db, $set)
	{
		//$sql = 'UPDATE `'.TABLE_NAME.'` SET '.implode(', ', $set).' LIMIT 1';  		
		$sql = "UPDATE `tbl_interface_manager` SET ".implode(', ', $set)." WHERE `blockid` = '".TABLE_NAME."' LIMIT 1";  		
		
		return MODEL::doQuery($sql, $db);
	}
	//end function		
	
	public static function autoCreateTables(&$db)
	{
		/*MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
							  `id` smallint(3) unsigned NOT NULL auto_increment,
							  `display` tinyint(1) unsigned NOT NULL default '1',
							  PRIMARY KEY  (`id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1	
					   "
					   , $db);*/
		
		MODEL::doQuery("CREATE TABLE IF NOT EXISTS `tbl_interface_manager` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `blockid` varchar(30) collate utf8_unicode_ci default NULL,
  `display` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1", $db);
		
		MODEL::PRO_InsertLangConfig($db, 'tbl_interface_manager', 'desc', 'longtext');	
	}
	
	protected static function PRO_InsertLangConfig(&$db, $table, $field, $type)
	{
		if (!$db->count_records('tbl_config_fields_lang', "LOWER(`table`) = LOWER('{$table}') AND LOWER(`field`) = LOWER('{$field}') AND LOWER(`type`) = LOWER('{$type}')")) {
			MODEL::doQuery("INSERT INTO `tbl_config_fields_lang` (`id`, `table`, `field`, `type`) VALUES (NULL, '{$table}', '{$field}', '{$type}')", $db);
		}
	}
	
}
//end class

?>