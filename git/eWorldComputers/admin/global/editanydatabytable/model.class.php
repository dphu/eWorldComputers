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
	
	//get data to edit
	public static function getData(&$db)
	{
		MODEL::doQuery('SELECT * FROM `'.TABLE_NAME.'` LIMIT 1', $db);
		
		return $db->numRows() ? $db->fetchRow() : NULL;
	}
	//end function	
	
	//query
	public static function doQuery($sql, &$db)
	{
		return __MYMODEL::__doQuery($sql, $db);
	}
	//end function
		
	public static function doInsert(&$db, &$fields, &$values)
	{
		$sql = 'INSERT INTO `'.TABLE_NAME.'` ('.implode(', ', $fields).') VALUES ('.implode(', ', $values).')';

		return MODEL::doQuery($sql, $db);
	}
	//end function		
	
	public static function doUpdate(&$db, $set)
	{
		$sql = 'UPDATE `'.TABLE_NAME.'` SET '.implode(', ', $set).' LIMIT 1';  
		
		return MODEL::doQuery($sql, $db);
	}
	//end function		
	
	public static function autoCreateTables(&$db)
	{
		MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
							  `id` smallint(3) unsigned NOT NULL auto_increment,
							  `display` tinyint(1) unsigned NOT NULL default '1',
							  PRIMARY KEY  (`id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1	
					   "
					   , $db);
		
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'desc', 'longtext');	
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