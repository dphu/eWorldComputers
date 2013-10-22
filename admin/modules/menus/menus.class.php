<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'configs/config.cfg.php';
require_once 'models/model.class.php';

class Menus extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	//private $loop = 5;
	
	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_TEXT = NULL;
	//da ngon ngu
	
	/**
    *@desc Phan trang du lieu
    */
    private $_rowperpage = 20;
    private $_pagerange = 10;
    private $_stylesheet = array(
								'page_cur'	=>  'page_cur',
								'page'      =>  'page',
							);
    private $queryString = ''; 

   
	//---------------------- constructor ------------------- //
	public function __construct(&$db)
	{
		$this->db = $db;
		//$this->__check_security();
		
		$this->path[] = '<a href="index.php">Administrator</a>';
        
		$this->queryString = 'index.php?module='.MODULE_NAME;
		
		//create DB
		MODEL::createDB($this->db);
		
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
		
		//set fields list
		$this->fieldsLangList = MULTI_LANGUAGE::getLangConfigInfo($this->db, TABLE_NAME);
		
		//auto create fields list
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_TEXT);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_TEXT);
	}
	
	//--------------------------------- view ---------------------------- //
	function view()
	{
		//save link
		$this->__auto_save_current_link();
		
		//paging
		$_count_records = $this->db->count_records(TABLE_NAME);
        $_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_pagerange,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString
        				 );
		$pagelist = $this->__create_pages_number_list($_count_records, &$_pageinfo, $this->_stylesheet, 'Trang: ');
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]

		#STT
        $stt = $_limit[0] + 1;
		
		//get data
		$rows = MODEL::getDataForViews($this->db, $_limit);
		
		//view list
		$this->path[] = '<strong>'.MODULE_DESC_VIEW.'</strong>';
		$this->title = TITLE_VIEW;
		
		return require "views/list.php";
	}
	
	################################################
	protected function PRO_GetCountSubCat($menu_id)
	{
		return $this->db->count_records('tbl_cat_news', "`menu_id` = {$menu_id}");
	}
	
	//------------------------------------- insert ----------------------- //
	function insert()
	{ 
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert()) {
				return $this->__redirect($this->__back_url());
			}
		} 		
		
		//text
		$this->path[] = '<strong>'.MODULE_DESC_INSERT.'</strong>';
		$this->title = TITLE_INSERT;
        	
		//form		
		return require 'views/insert.php';
	}	
	
	################################################
	protected function PRO_DuplicateField($field, $value, $id = 0)
	{
		return $this->db->count_records(TABLE_NAME, "`{$field}` LIKE '{$value}' AND `id` <> {$id}") ? true : false;
	}
	
	//---------------------------------------- do insert --------------------- //
	private function PRI_DoInsert()
	{
		#get cac gia tri tren form submit & check validation
		$fields = array();
		foreach ($_POST as $key => $value) {
			if (in_array($key, $this->field_TEXT)) {
				//get
				$fields[$key] = IO::getPOST($key);
				//check validation
				if ($fields[$key] == '') {
					ERROR::setError($key, EMPTY_TITLE);
				} elseif ($this->PRO_DuplicateField($key, $fields[$key])) {
					ERROR::setError($key, DUPLICATE_TITLE);
				}
			}
		}	
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//insert
		MODEL::doInsert($this->db, $fields);
		
		//ok
		return true;
	}
	
	// ----------------------------- edit ----------------- //	 
	public function edit()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoEdit()) {
				return $this->__redirect($this->__back_url());
			}	
		}
		
	 	//id
		if (!$id = IO::getID()) {
			return $this->__redirect($this->__back_url());
		}
		
	 	//text
		$this->path[] = '<strong>'.MODULE_DESC_EDIT.'</strong>';
		$this->title = TITLE_EDIT;
		
		#get info on DB
		if (!ERROR::isError()) {
			if (!MODEL::getDataForEdit($this->db, $id, $this->field_TEXT)) {
				return $this->__redirect($this->__back_url());
			}
		}	

		#view
		return require 'views/edit.php';
    }

	// ------------------ do edit ---------------------------------- //
	private function PRI_DoEdit()
	{
		#get id
		if (!$id = IO::getID()) {
			return $this->__redirect('index.php');
		}
		
		#get cac gia tri tren form submit & check validation
		$fields = array();
		foreach ($_POST as $key => $value) {
			if (in_array($key, $this->field_TEXT)) {
				//get
				$fields[$key] = IO::getPOST($key);
				//check validation
				if ($fields[$key] == '') {
					ERROR::setError($key, EMPTY_TITLE);
				} elseif ($this->PRO_DuplicateField($key, $fields[$key], $id)) {
					ERROR::setError($key, DUPLICATE_TITLE);
				}
			}
		}	
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//update
		MODEL::doUpdate($this->db, $fields, $id);
		
		//ok
		return true;
	}
	
	// ------------------------- delete ------------------------------- //
    public function delete()
	{
	   	if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['delete']))	   {
            return $this->__auto_refresh();
        }

		$idList = array(0);
       	for ($i=0; $i<count($_POST['delete']); $i++) {
            if ($id = intval($_POST['delete'][$i])) {
				$idList[] = $id;
		    }
		}	
		$idList = '(' . implode(',', $idList) . ')';
		
		//delete
		MODEL::doDelete($this->db, $idList);

        //return		
        return $this->__auto_refresh();
    }
	
	// --------------------- delete sub cat ------------------- //
	private function PRI_deleteAllSubCatList($where = '')
	{
		$this->db->query("SELECT `id` FROM `tbl_cat_news` {$where}");
		
		if ($this->db->numRows()) {
			$idList = array(0);
			while ($row = $this->db->fetchRow()) {
				$idList[] = $row->id;
			}
			$idList = '(' . implode(',', $idList) . ')';
			//delete news
			$this->db->query("DELETE FROM `tbl_news` WHERE `cat_id` IN {$idList}");
			//delete cat news
			$this->db->query("DELETE FROM `tbl_cat_news` WHERE `id` IN {$idList}");
		}	
	}
	
	###############
	public function set_display()
	{
		$info = array(
						'tablename'		=>		TABLE_NAME,
						'field_id'		=>		'id',
						'field_display'	=>		'display',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'display'	
					 );
		$this->__set_display_field_on_table($info);
		
		return $this->__auto_refresh(); 
	}
	################

	###############
	public function set_ordering()
	{
		$info = array(
						'table_name'		=>	TABLE_NAME,
						'id_field'			=>	'id',
						'ordering_field'	=>	'ordering'
					 );
		$this->__auto_set_ordering($info);
	
		return $this->__auto_refresh();
	}
	################	
	
}
//end class

?>