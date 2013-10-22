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
	
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_NAME, &$field_PARTICULAR, &$field_DESC)
	{
		$field_NAME = array();
		$field_PARTICULAR = array();
		$field_DESC = array();
		
		for ($i=0; $i<count($fieldsLangList); $i++) {
			if ($fieldsLangList[$i] == 'name') {
				$field_NAME[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
			} elseif ($fieldsLangList[$i] == 'particular') {
				$field_PARTICULAR[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
			} else {
				$field_DESC[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
			}
		}
		
		$field_NAME = $field_NAME[0];
		$field_PARTICULAR = $field_PARTICULAR[0];
		$field_DESC = $field_DESC[0];
	}
	
	//get data to views
	public static function getDataForViews(&$db, &$where, &$limit, &$field_NAME, &$field_PARTICULAR)
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
	
	//get data to edit
	public static function getDataForEdit(&$db, &$id = 0)
	{
		$sql = "SELECT * FROM `".TABLE_NAME."` WHERE `id` = {$id} LIMIT 1"; 
		MODEL::doQuery($sql, $db);
		
		if ($db->numRows()) {
			foreach ($db->fetchRow() as $key => $value) {
				IO::setPost($key, $value);
				if ($key == 'image') {
					IO::setPost('oldimage', $value);
				}
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
	
	public static function doInsert(&$db, &$fields = array(), &$values = array())
	{
		$sql = "INSERT INTO `".TABLE_NAME."` (`" . implode('`, `', $fields) . "`) VALUES ('" . implode("', '", $values) . "')";  
		
		return MODEL::doQuery($sql, $db);	
	}
	//end function
	
	public static function doUpdate(&$db, &$id, &$set)
	{
		$sql = "UPDATE `".TABLE_NAME."` 
				SET ".implode(', ', $set)."
				WHERE `id` = {$id}
				LIMIT 1"; 
		MODEL::doQuery($sql, $db);	
	}
	//end function		
	
	public static function doDelete(&$db, &$idList)
	{
		//delete image thumb
		MODEL::doQuery("SELECT `image` FROM `".TABLE_NAME."` WHERE `id` IN {$idList}", $db);
		if ($db->numRows()) {
			while ($r = $db->fetchRow()) {
				//$t = '../'.$r->image;
				//$l = str_replace(UPLOAD_PRODUCT_PATH.'/', UPLOAD_PRODUCT_PATH.'/098', $t); 
				//@unlink ($t);
				//@unlink ($l);
			}
		}
		
		//delete images list
		MODEL::doDeleteImagesList($db, $idList);
		
		//delete us
		MODEL::doQuery("DELETE FROM `".TABLE_NAME."` WHERE `id` IN {$idList}", $db);
	}
	//end function
	
	private static function doDeleteImagesList(&$db, &$product_id_list)
	{
		//MODEL::doQuery("SELECT `image` FROM `".TABLE_IMAGES_NAME."` WHERE `product_id` IN {$product_id_list}", $db);
		//if ($db->numRows()) {
			//while ($row = $db->fetchRow()) {
				//@unlink ('../' . $row->image);
			//}
		//}
		
		MODEL::doQuery("DELETE FROM `".TABLE_IMAGES_NAME."` WHERE `product_id` IN {$product_id_list}", $db);
	}
	//end function
	
	public static function autoCreateTables(&$db)
	{
		MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) default '0',
  `code` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `price` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `image` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `new` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `display` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1
						", $db);
		
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'name', 'varchar(50)');				
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'particular', 'longtext');				
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'desc', 'longtext');				
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, _SERIALIZE, 'longtext');	
		
		MODEL::doQuery('ALTER TABLE `'.TABLE_NAME.'` ADD `pagetitle` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL', $db);
		MODEL::doQuery('ALTER TABLE `'.TABLE_NAME.'` ADD `metakeyword` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL', $db);
		MODEL::doQuery('ALTER TABLE `'.TABLE_NAME.'` ADD `metadescription` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL', $db);
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