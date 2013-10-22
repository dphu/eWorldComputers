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
	
	public static function autoCreateFieldList(&$keyLangList, &$fieldsLangList, &$field_TITLE, &$field_DESCRIPTION, &$field_CONTENT, &$field_FORMCONFIG)
	{
		$field_TITLE = array();
		$field_DESCRIPTION = array();
		$field_CONTENT = array();
		$field_FORMCONFIG = array();
		for ($i=0; $i<count($fieldsLangList); $i++) {
			${'field_'.strtoupper($fieldsLangList[$i])}[] = MULTI_LANGUAGE::createFieldsList($keyLangList, $fieldsLangList[$i]);
		}
		$field_TITLE = $field_TITLE[0];
		$field_DESCRIPTION = $field_DESCRIPTION[0];
		$field_CONTENT = $field_CONTENT[0];
		$field_FORMCONFIG = $field_FORMCONFIG[0];
	}
	
	//get data to views
	public static function getDataForViews(&$db, &$where, &$limit)
	{
		$dateOrderMode = USE_DATETIME ? 'desc' : '';
		
		$sql = "SELECT * 
				FROM `".TABLE_NAME."`
				{$where}
				ORDER BY `ordering`, `id`, `date` {$dateOrderMode} 
				LIMIT {$limit[0]} , {$limit[1]}";
		MODEL::doQuery($sql, $db);
		
		return $db->numRows() ? $db->fetchRowSet() : NULL;
	}
	//end function	
	
	//get data to edit
	public static function getDataForEdit(&$db, &$id)
	{
		if ($row = __MYMODEL::__doSELECT($db, '*', TABLE_NAME, "WHERE `id` = {$id}", NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			foreach ($row as $key => $value) 
			{
				IO::setPost($key, $value);
			}
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	

	}
	//end function	
	
	//query
	public static function doQuery($sql, &$db)
	{
		$db->query($sql);
	}
	//end function
	
	//update news
	public static function doUpdate(&$db, &$id, &$field_TITLE = array(), &$field_DESCRIPTION = array(), &$field_CONTENT = array(), &$field_FORMCONFIG = array(), &$titles, &$descriptions, &$contents, &$formconfigs , &$pagetitle,&$metakeyword, &$metadescription)
	{
		$setPagetitle = "`pagetitle` = '{$pagetitle}',";
		$setMetakeyword = "`metakeyword` = '{$metakeyword}',";
		$setMetadescription = "`metadescription` = '{$metadescription}',";
		
		$setTitle = '';
		$setDescription = '';
		$setContent = '';
		$setFormconfig = '';
		for ($i=0; $i<count($field_TITLE); $i++) {
			$setTitle .= "`{$field_TITLE[$i]}` = '{$titles[$i]}', ";
			$setDescription .= "`{$field_DESCRIPTION[$i]}` = '{$descriptions[$i]}', ";
			$setContent .= "`{$field_CONTENT[$i]}` = '{$contents[$i]}', ";
			$setFormconfig .= "`{$field_FORMCONFIG[$i]}` = '{$formconfigs[$i]}', ";
		}
		
		$sql = "UPDATE `" . TABLE_NAME . "` 
				SET {$setTitle} {$setDescription} {$setContent} {$setFormconfig} {$setPagetitle} {$setMetakeyword} {$setMetadescription} `date` = " . time() . ", `tinh_id` = " . abs(intval(IO::getPOST('tinh_id'))) . "
				WHERE `id` = {$id}
				LIMIT 1"; 
		
		return MODEL::doQuery($sql, $db);	
	}
	//end function		
	
	//insert news
	public static function doInsert(&$db, &$cat_id = 0, &$field_TITLE = array(), &$field_DESCRIPTION = array(), &$field_CONTENT = array(), &$field_FORMCONFIG = array(), &$titles = '', &$descriptions = '', &$contents = '', &$formconfigs = '', &$pagetitle = '', &$metakeyword = '', &$metadescription = '')
	{
		$sql = "INSERT INTO `" . TABLE_NAME . "` 
				(
					`id`, 
					`cat_id`, 
					`" . implode('`, `', $field_TITLE) . "`,
					`" . implode('`, `', $field_DESCRIPTION) . "`,
					`" . implode('`, `' ,$field_CONTENT) . "`,
					`" . implode('`, `' ,$field_FORMCONFIG) . "`,
					`date`, 
					`ordering`, 
					`display`,
					`tinh_id`,
					`pagetitle`,
					`metakeyword`,
					`metadescription`
				)
				VALUES 
				(
					NULL, 
					{$cat_id}, 
					'" . implode("', '", $titles) . "',
					'" . implode("', '", $descriptions) . "',
					'" . implode("', '", $contents) . "',
					'" . implode("', '", $formconfigs) . "',
					" . time() . ", 
					0, 
					1,
					" . abs(intval(IO::getPOST('tinh_id'))) . ",
					'{$pagetitle}',
					'{$metakeyword}',
					'{$metadescription}'
				)"; 
		return MODEL::doQuery($sql, $db);	
	}
	//end function		
	
	###############################################
	public static function doDelete(&$db, &$idList)
	{
		MODEL::doQuery("DELETE FROM `" . TABLE_NAME . "` WHERE `id` IN {$idList}", $db);
	}
	//end function
	
	####################################
	public static function createDB(&$db)
	{
		MODEL::doQuery("
							CREATE TABLE IF NOT EXISTS `".TABLE_NAME."` (
						 	`id` int(11) unsigned NOT NULL auto_increment,
						  	`cat_id` int(11) unsigned NOT NULL default '0',
							`date` int(11) default NULL,
							`ordering` int(11) NOT NULL default '1',
							`display` tinyint(1) NOT NULL default '1',
							PRIMARY KEY  (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
						", $db);
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'title', 'varchar(255)');
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'description', 'longtext');
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'content', 'longtext');
		MODEL::PRO_InsertLangConfig($db, TABLE_NAME, 'formconfig', 'longtext');
				
		$db->query("ALTER TABLE `".TABLE_NAME."` ADD `isnew` TINYINT(1) UNSIGNED NULL DEFAULT '0'");
		$db->query("ALTER TABLE `".TABLE_NAME."` ADD `ishidetitle` TINYINT(1) UNSIGNED NULL DEFAULT '0'");
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