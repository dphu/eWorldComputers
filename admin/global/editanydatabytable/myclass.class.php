<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

class MYCLASS extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	
	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_DESC = NULL;
	
	//---------------------- constructor ------------------- //
	public function __construct(&$db)
	{
		$this->db = $db;
		
		MODEL::autoCreateTables($this->db);
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = '<strong>'.MODULE_DESC.'</strong>';
		
		$this->title = MODULE_DESC;
		
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
		
		//set fields list
		$this->fieldsLangList = MULTI_LANGUAGE::getLangConfigInfo($this->db, TABLE_NAME);
		
		//auto create fields list
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_DESC);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_DESC);
		
		//first insert
		$this->PRI_DoFirstInsert();
	}
	
	//first insert
	private function PRI_DoFirstInsert()
	{
		if (!$this->db->count_records(TABLE_NAME)) {
			$fields = array();
			$values = array();
			for ($i=-0; $i<count($this->keyLangList); $i++) {
				$fields[] = "`{$this->field_DESC[$i]}`";
				$values[] = "''";
			}
			MODEL::doInsert($this->db, $fields, $values);
		}
	}
	//end function
	
	//function edit database
	public function edit()
	{
		//save link
		IO::setBackURL();
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->PRI_DoEdit();
			
			
			return IO::redirect('index.php');
		}

		#get info on DB
		$row = MODEL::getData($this->db);
		
		#view
		return require 'global/editanydatabytable/edit.php';
    }
	//end function

	// ------------------ do edit ---------------------------------- //
	private function PRI_DoEdit()
	{
		$set = array();
		
		#get cac gia tri tren form submit & check validation
		$set[] = '`display` = ' . IO::getPOST('display');
		for ($i=0; $i<count($this->keyLangList); $i++) {
			$set[] = "`{$this->field_DESC[$i]}` = '" . IO::getPOST($this->field_DESC[$i], '', true). "'";
		}
		
		//update
		MODEL::doUpdate($this->db, $set);		
		
		//return 
		return true;
	}
	
		
}
//end class

?>