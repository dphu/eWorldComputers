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
	
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_TITLE, &$field_CONTENT)
	{
		$field_TITLE = array();
		$field_CONTENT = array();
		for ($i=0; $i<count($fieldsLangList); $i++) {
			if ($fieldsLangList[$i] == 'title') {
				$field_TITLE[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
			} elseif ($fieldsLangList[$i] == 'content') {
				$field_CONTENT[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
			}	
		}
		$field_TITLE = $field_TITLE[0];
		$field_CONTENT = $field_CONTENT[0];
	}
	
	//get data to views
	public static function getDataForViews(&$db, &$limit, &$field_TITLE)
	{
		$sql = "SELECT 
						`id` , 
						" . implode(', ', $field_TITLE) . ", 
						`ordering` , 
						`display`
				FROM `".TABLE_NAME."`
				ORDER BY `ordering`  
				LIMIT {$limit[0]} , {$limit[1]}"; 
		MODEL::doQuery($sql, $db);
		
		return $db->numRows() ? $db->fetchRowSet() : NULL;
	}
	//end function	
	
	//get data to edit
	public static function getDataForEdit(&$db, $id = 0)
	{
		$sql = "SELECT * FROM `".TABLE_NAME."` WHERE `id` = {$id} LIMIT 1"; 
		MODEL::doQuery($sql, $db);
		
		if ($db->numRows()) {
			$row = $db->fetchRow();
			foreach ($row as $key => $value) {
				IO::setPost($key, $value);
			}
			return true; 
		} else {
			return false;
		}
	}
	//end function	
	
	//query
	public static function doQuery($sql, $db = NULL)
	{
		if (!is_object($db)) {
			global $db;
		}
		
		$db->query($sql);
	}
	//end function
	
	
	public static function doInsert(&$db, $field_TITLE = array(), $titleData = array(), $field_CONTENT = array(), $contentData = array())
	{
		$sql = "INSERT INTO `".TABLE_NAME."` 
				(
					`id` ,
						" . implode(', ',$field_TITLE) . " ,
						" . implode(', ',$field_CONTENT) . " ,
						`ordering` ,
						`display`
				)
				VALUES 
				(
					NULL , 
					" . implode(', ',$titleData) . " ,
					" . implode(', ',$contentData) . " ,
					'0', 
					'1'
				)";  
		return MODEL::doQuery($sql);	
	}
	//end function		
	
	public static function doDelete($db, $where = NULL)
	{
		return MODEL::doQuery("DELETE FROM `".TABLE_NAME."` {$where}", $db);
	}
	//end function
	
	public static function doDeleteImagesList($db, $where = NULL, $dirpath = NULL)
	{
		MODEL::doQuery("SELECT `filename` FROM `".TABLE_NAME_IMAGE."` {$where}", $db);
		
		if ($db->numRows()) {
			while ($row = $db->fetchRow()) {				
				@unlink($dirpath . $row->filename);
				@unlink($dirpath . '0986174211' . $row->filename);
			}
			MODEL::doQuery("DELETE FROM `".TABLE_NAME_IMAGE."` {$where}", $db);
		}
	}
	//end function
	
	public static function autoCreateTables(&$db)
	{
		MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
							  `id` int(5) unsigned NOT NULL auto_increment,
							  `ordering` int(5) unsigned NOT NULL default '0',
							  `display` tinyint(1) unsigned NOT NULL default '1',
							  PRIMARY KEY  (`id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
						", $db);
		
		MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME_IMAGE."` (
							  `id` int(11) unsigned NOT NULL auto_increment,
							  `cat_id` int(11) unsigned NOT NULL default '0',
							  `filename` varchar(255) collate utf8_unicode_ci default NULL,
							  `ordering` int(11) unsigned NOT NULL default '1',
							  `display` tinyint(1) unsigned NOT NULL default '1',
							 PRIMARY KEY  (`id`)) 
							 ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
						", $db);
						
		MODEL::PRO_InsertLangConfig(&$db, TABLE_NAME, 'title', 'varchar(255)');				
		MODEL::PRO_InsertLangConfig(&$db, TABLE_NAME, 'content', 'longtext');				
	}
	
	protected static function PRO_InsertLangConfig(&$db, $table, $field, $type)
	{
		if (!$db->count_records('tbl_config_fields_lang', "LOWER(`table`) = LOWER('{$table}') AND LOWER(`field`) = LOWER('{$field}') AND LOWER(`type`) = LOWER('{$type}')")) {
			MODEL::doQuery("INSERT INTO `tbl_config_fields_lang` (`id`, `table`, `field`, `type`) VALUES (NULL, '{$table}', '{$field}', '{$type}')");
		}
	}
	
}
//end class

?>