<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

class PRO_CAT_MODEL
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
	
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_NAME, &$field_DESCRIPTION)
	{
		$field_NAME = array();
		$field_DESCRIPTION = array();
		for ($i=0; $i<count($fieldsLangList); $i++) 
		{
			${'field_'.strtoupper($fieldsLangList[$i])}[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
		}
		$field_NAME = $field_NAME[0];
		$field_DESCRIPTION = $field_DESCRIPTION[0];
	}
	
	//get data to views
	public static function getDataForViews(&$db, &$limit, &$field_NAME)
	{
		$sql = "SELECT 
						`id`,
						`".implode('`, `', $field_NAME)."`,
						`display`,
						`ordering` 
				FROM `".PRO_CAT_TABLE_NAME."` 
				WHERE `parent_id` = 0
				ORDER BY 
						`ordering`,
						`id` DESC
				LIMIT {$limit[0]}, {$limit[1]}"; 
		PRO_CAT_MODEL::doQuery($sql, $db);
		
		return $db->numRows() ? $db->fetchRowSet() : NULL;
	}
	//end function	
	
	//get data to edit
	public static function getDataForEdit(&$db, $id = 0)
	{
		$sql = "SELECT * FROM `".PRO_CAT_TABLE_NAME."` WHERE `id` = {$id} LIMIT 1"; 
		PRO_CAT_MODEL::doQuery($sql, $db);
		
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
	
	
	public static function doInsert(&$db, $field_NAME = array(), $nameData = array())
	{
		$sql = "INSERT INTO `".PRO_CAT_TABLE_NAME."` 
				(
					`id` ,
					`parent_id`,
					`" . implode('`, `', $field_NAME) . "` ,
					`ordering` ,
					`display`
				)
				VALUES 
				(
					NULL,
					0, 
					'" . implode("', '", $nameData) . "',
					0, 
					1
				)";  
		return PRO_CAT_MODEL::doQuery($sql, $db);	
	}
	//end function
	
	public static function doUpdate(&$db, &$field_NAME = array(), &$nameData = array(), &$id=0)
	{
		$set = array();
		for ($i=0; $i<count($field_NAME); $i++) {
			$set[] = "`{$field_NAME[$i]}` = '{$nameData[$i]}'";
		}
		$sql = "UPDATE `".PRO_CAT_TABLE_NAME."` 
				SET ".implode(', ', $set)."
				WHERE `id` = {$id}
				LIMIT 1"; 
		
		return PRO_CAT_MODEL::doQuery($sql, $db);	
	}
	//end function		
	
	public static function doDelete(&$db, &$idList)
	{
		//delete chirldren
		PRO_CAT_MODEL::doDeleteProducts($db, $idList);
		
		//delete me
		PRO_CAT_MODEL::doQuery("DELETE FROM `".PRO_CAT_TABLE_NAME."` WHERE `id` IN {$idList}", $db);
	}
	//end function
	
	private function doDeleteProducts(&$db, &$idList)
	{
		//get products id list
		$product_id_list = array(0);
		PRO_CAT_MODEL::doQuery("SELECT `id`, `image` FROM `".PRO_CAT_TABLE_PRODUCTS_NAME."` WHERE `cat_id` IN {$idList}", $db);
		if ($db->numRows()) {
			while ($r = $db->fetchRow()) {
				$product_id_list[] = $r->id;
				//delete rewriteurl
				__REWRITEURL::DeleteURL($db, PRO_CAT_TABLE_PRODUCTS_NAME, $r->id);
				//delete image thumb
				//$t = '../'.$r->image;
				//$l = str_replace(UPLOAD_PRODUCT_PATH.'/', UPLOAD_PRODUCT_PATH.'/098', $t); 
				//@unlink ($t);
				//@unlink ($l);
			}
		}
		$product_id_list = '(' . implode(', ', $product_id_list) . ')';
		
		//delete images list
		PRO_CAT_MODEL::doDeleteImagesList($db, $product_id_list);
		
		//delete me
		PRO_CAT_MODEL::doQuery("DELETE FROM `".PRO_CAT_TABLE_PRODUCTS_NAME."` WHERE `cat_id` IN {$idList}", $db);
	}
	
	private static function doDeleteImagesList(&$db, &$product_id_list)
	{
		//PRO_CAT_MODEL::doQuery("SELECT `image` FROM `".PRO_CAT_TABLE_IMAGES_NAME."` WHERE `product_id` IN {$product_id_list}", $db);
		//if ($db->numRows()) {
			//while ($row = $db->fetchRow()) {
				//@unlink ('../' . $row->image);
			//}
		//}
		
		PRO_CAT_MODEL::doQuery("DELETE FROM `".PRO_CAT_TABLE_IMAGES_NAME."` WHERE `product_id` IN {$product_id_list}", $db);
	}
	//end function
	
	public static function autoCreateTables(&$db)
	{
		PRO_CAT_MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".PRO_CAT_TABLE_NAME."` (
							`id` int(11) NOT NULL auto_increment,
							  `parent_id` int(11) default '0',
							  `display` tinyint(1) NOT NULL default '1',
							  `ordering` int(11) NOT NULL default '0',
							  PRIMARY KEY  (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1
						", $db);
		
		PRO_CAT_MODEL::PRO_InsertLangConfig($db, PRO_CAT_TABLE_NAME, 'name', 'varchar(255)');
		PRO_CAT_MODEL::PRO_InsertLangConfig($db, PRO_CAT_TABLE_NAME, 'description', 'text');			
		
		$db->query("ALTER TABLE `".PRO_CAT_TABLE_NAME."` ADD `isdf` TINYINT(1) UNSIGNED NULL DEFAULT '0'");		
	}
	
	protected static function PRO_InsertLangConfig(&$db, $table, $field, $type)
	{
		if (!$db->count_records('tbl_config_fields_lang', "LOWER(`table`) = LOWER('{$table}') AND LOWER(`field`) = LOWER('{$field}') AND LOWER(`type`) = LOWER('{$type}')")) {
			PRO_CAT_MODEL::doQuery("INSERT INTO `tbl_config_fields_lang` (`id`, `table`, `field`, `type`) VALUES (NULL, '{$table}', '{$field}', '{$type}')");
		}
	}
	
}
//end class

?>