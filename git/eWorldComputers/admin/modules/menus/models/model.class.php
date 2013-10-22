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
	
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_TEXT)
	{
		$field_TEXT = array();
		for ($i=0; $i<count($fieldsLangList); $i++) {
			$field_TEXT[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
		}
		$field_TEXT = $field_TEXT[0];
	}
	
	//get data to views
	public static function getDataForViews(&$db, &$limit)
	{
		$sql = "SELECT *
				FROM `".TABLE_NAME."`
				ORDER BY `ordering`  
				LIMIT {$limit[0]} , {$limit[1]}";
		MODEL::doQuery($sql, $db);
		
		return $db->numRows() ? $db->fetchRowSet() : NULL;
	}
	//end function	
	
	//get data to edit
	public static function getDataForEdit(&$db, &$id, &$field_TEXT)
	{
		MODEL::doQuery("SELECT `".implode('`, `', $field_TEXT)."` FROM `".TABLE_NAME."` WHERE `id` = {$id} LIMIT 1", $db);
		
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
	public static function doQuery($sql, &$db)
	{
		$db->query($sql);
	}
	//end function
	
	//update
	public static function doUpdate(&$db, &$fields, &$id)
	{
		$list = '';
		foreach ($fields as $field => $value) {
			if ($list == '') { 
				$list .= "SET `{$field}` = '{$value}'";
			} else {
				$list .= ", `{$field}` = '{$value}'";
			}	
		}
		
		$sql = "UPDATE `".TABLE_NAME."` {$list} WHERE `id` = {$id} LIMIT 1";
		return MODEL::doQuery($sql, $db);
	}
	
	public static function doInsert(&$db, &$list)
	{
		$field = '';
		$value = '';
		foreach ($list as $k => $v) {
			$field .= ", `{$k}`";
			$value .= ", '{$v}'";
		}
		
		$sql = "INSERT INTO `".TABLE_NAME."` 
				(
					`id` 
					{$field},
					`ordering` ,
					`display`
				)
				VALUES 
				(
					NULL 
					{$value},
					'0', 
					'1'
				)";  
		return MODEL::doQuery($sql, $db);	
	}
	//end function		
	
	public static function doDelete(&$db, &$idList)
	{
		//delete sub cat news
		MODEL::doQuery("SELECT `id` FROM `tbl_cat_news` WHERE `menu_id` IN {$idList}", $db);
		if ($db->numRows()) {
			$catidList = array(0);
			while ($row = $this->db->fetchRow()) {
				$catidList[] = $row->id;
			}
			$catidList = '(' . implode(',', $catidList) . ')';
			//delete news
			MODEL::doQuery("DELETE FROM `tbl_news` WHERE `cat_id` IN {$catidList}", $db);
			//delete sub cat news
			MODEL::doQuery("DELETE FROM `tbl_cat_news` WHERE `id` IN {$idList}", $db);
		}	
		
		//delete main cat
		MODEL::doQuery("DELETE FROM `".TABLE_NAME."` WHERE `id` IN {$idList}", $db);
	}
	//end function
	
	public static function createDB(&$db)
	{
		MODEL::doQuery("
						CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
						`id` int(11) unsigned NOT NULL auto_increment,
						`ordering` int(11) NOT NULL default '1',
						`display` tinyint(1) NOT NULL default '1',
						 PRIMARY KEY  (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
						", $db);
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'text', 'varchar(50)');				
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