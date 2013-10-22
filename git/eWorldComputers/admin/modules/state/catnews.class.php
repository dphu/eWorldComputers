<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'configs/config.cfg.php';
require_once 'models/model.class.php';

class Catnews extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	
	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_NAME = NULL;
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
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_NAME);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_NAME);
				
		if (IO::getKey('update') == 'google')
		{
			__MYMODEL::__doDELETE($this->db, TABLE_NAME, NULL);
			$s = explode('<', @file_get_contents('state.tpl'));
			for ($i=3; $i<count($s); $i+=2)
			{
				$s[$i] = explode('>', $s[$i]);
				$name = $s[$i][1];
				$s[$i][0] = explode('=', $s[$i][0]);
				$code = str_replace(array('"', "'"), '', $s[$i][0][1]);
				__MYMODEL::__doINSERT($this->db, TABLE_NAME, array('`display`', '`name_en`', 'code'), array(1, "'{$name}'", "'{$code}'"));
			}
		}
		
	}
	//end function 
	
	###############################################################
	private function PRI_CreateCatMenusComboBox(&$menu_id , &$cbmn, $mode = 'view')
	{
		$cbmn = ($mode == 'view') ? '<select onchange="javascript:window.location.href=\'index.php?module='.MODULE_NAME.'&menu=\' + this.value">' : '<select name="menu_id" id="menu_id">';
		$cbmn .= ($mode != 'edit') ? '<option value="0" selected="selected" >&nbsp;&nbsp;---------------&nbsp;&nbsp;</option>' : '';
		MODEL::doQuery('SELECT `id`, `text_'.$this->keyLangList[0].'` AS `text` FROM `'.TABLE_CAT_NAME.'` ORDER BY `ordering`', $this->db);
		if ($this->db->numRows()) {
			while ($r = $this->db->fetchRow()) {
				$sel = ($r->id == $menu_id) ? 'selected="selected"' : '';
				$cbmn .= "<option value='{$r->id}' {$sel} >&nbsp;&nbsp;{$r->text}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
			}
		}
		$cbmn .= '</select>';
	}
	//end function
	
	//--------------------------------- view ---------------------------- //
	public function view()
	{
		//save link
		$this->__auto_save_current_link();
		
		//menu id
		$menu_id = IO::getID('menu');
		
		//combobox Danh mục chính
		$this->PRI_CreateCatMenusComboBox($menu_id, $combobox, 'view');
		
		//where
		$where = $menu_id ? "WHERE `menu_id` = {$menu_id}" : '';
		
		//paging
		$_count_records = $this->db->count_records(TABLE_NAME, $where);
        $_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_pagerange,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString . "&menu={$menu_id}"
        				 );
		$pagelist = $this->__create_pages_number_list($_count_records, &$_pageinfo, $this->_stylesheet, 'Trang: ');
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]

		#STT
        $stt = $_limit[0] + 1;
		
		//get data
		$rows = MODEL::getDataForViews($this->db, $where, $_limit);
		
		//view list
		$this->path[] = '<strong>'.MODULE_DESC_VIEW.'</strong>';
		$this->title = TITLE_VIEW;
		return require_once 'views/list.php';
	}
	//end function
	
	###################################
	protected function PRO_GetCountNews($cat_id)
	{
		return $this->db->count_records(TABLE_CHILD_NAME, "`cat_id` = {$cat_id}");
	}
	//end function
	
	//------------------------------------- insert ----------------------- //
	public function insert()
	{ 
		if (!ALI)
		{
			return $this->__redirect('index.php');
		}
		
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert()) {
				return $this->__redirect($this->__back_url());
			} else {
				$menu_id = IO::getPOST('menu_id');
			}
		} else { 		
			$menu_id = IO::getID('menu');
		}	
		
		//combobox Danh mục chính
		$this->PRI_CreateCatMenusComboBox($menu_id , $combobox, 'insert');
		
		//text
		$this->path[] = '<strong>'.MODULE_DESC_INSERT.'</strong>';
		$this->title = TITLE_INSERT;
        	
		//form		
		return require 'views/insert.php';
	}	
	
	//dup value?
	protected function PRO_DuplicateField($field, $value, $menu_id, $id = 0)
	{
		return ALLOW_DUPPLICATE_TITLE ? FALSE : $this->db->count_records(TABLE_NAME, "`{$field}` LIKE '{$value}' AND `id` <> {$id} AND `menu_id` = {$menu_id}") ? true : false;
	}
	
	//---- do insert ----------- //
	private function PRI_DoInsert()
	{
		#get cac gia tri tren form submit & check validation
		if (!$menu_id = IO::getPOST('menu_id')) {
			ERROR::setError('menu_id', EMPTY_NAME);
		}

		$fields = array();
		foreach ($_POST as $key => $value) {
			if (in_array($key, $this->field_NAME)) {
				//get
				$fields[$key] = IO::getPOST($key);
				//check validation
				if ($fields[$key] == '') {
					ERROR::setError($key, EMPTY_NAME);
				} elseif ($this->PRO_DuplicateField($key, $fields[$key], $menu_id)) {
					ERROR::setError($key, DUPLICATE_NAME);
				}
			}
			elseif ($key == 'code')
			{
				$fields[$key] = IO::getPOST($key);
			}
		}
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//insert
		MODEL::doInsert($this->db, $fields, $menu_id);
		
		//ok
		return true;
	}
	
	// ----------------------------- edit ----------------- //	 
	public function edit()
	{
		//id
		if (!$id = IO::getID()) {
			return $this->__redirect($this->__back_url());
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($this->PRI_DoEdit()) {
				return $this->__redirect($this->__back_url());
			} else {
				$menu_id = MODEL::getMenuId($this->db, $id);
			} 
		} else {
			$menu_id = MODEL::getMenuId($this->db, $id);
		}
		
	 	//combobox Danh mục chính
		$this->PRI_CreateCatMenusComboBox($menu_id, $combobox, 'edit');

	 	//text
		$this->path[] = MODULE_DESC_EDIT;
		$this->title = TITLE_EDIT;
		
		#get info on DB
		if (!ERROR::isError()) {
			if (!MODEL::getDataForEdit($this->db, $id, $this->field_NAME)) {
				return $this->__redirect($this->__back_url());
			}
		}	
		
		#view
		return require 'views/insert.php';
    }

	// ------------------ do edit ---------------------------------- //
	private function PRI_DoEdit()
	{
		//id
		if (!$id = IO::getID()) {
			return $this->__redirect('index.php');
		}
		
		#get cac gia tri tren form submit & check validation
		if (!$menu_id = IO::getPOST('menu_id')) {
			ERROR::setError('menu_id', EMPTY_NAME);
		}
		$fields = array();
		foreach ($_POST as $key => $value) {
			if (in_array($key, $this->field_NAME)) {
				//get
				$fields[$key] = IO::getPOST($key);
				//check validation
				if ($fields[$key] == '') {
					ERROR::setError($key, EMPTY_NAME);
				} elseif ($this->PRO_DuplicateField($key, $fields[$key], $menu_id, $id)) {
					ERROR::setError($key, DUPLICATE_NAME);
				}
			}
			elseif ($key == 'code')
			{
				$fields[$key] = IO::getPOST($key);
			}
		}
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//update
		MODEL::doUpdate($this->db, $menu_id, $fields, $id);
		
		//ok
		return true;
	}
	
	// ------------------------- delete ------------------------------- //
    public function delete()
	{
		if (!ALD)
		{
			return $this->__redirect('index.php');
		}
		
	   	if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['delete'])) {
            return $this->__auto_refresh();
        }

		$idList = array(0);
       	for ($i=0; $i<count($_POST['delete']); $i++) {
			if ($id = intval($_POST['delete'][$i])) {
				$idList[] = $id;
		    }
		}	
		$idList = '(' . implode(',', $idList) . ')';
		
		//do delete
		MODEL::doDelete($this->db, $idList);
		
		 //return		
        return $this->__auto_refresh();
    }
	
	
	###############
	function set_display()
	{
		if (!ALSD)
		{
			return $this->__redirect('index.php');
		}
		
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
	function set_istinh()
	{
		$info = array(
						'tablename'		=>		TABLE_NAME,
						'field_id'		=>		'id',
						'field_display'	=>		'istinh',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'istinh'	
					 );
		$this->__set_display_field_on_table($info);
		
		return $this->__auto_refresh(); 
	}
	################
	
	###############
	function set_isfaq()
	{
		$info = array(
						'tablename'		=>		TABLE_NAME,
						'field_id'		=>		'id',
						'field_display'	=>		'isfaq',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'isfaq'	
					 );
		$this->__set_display_field_on_table($info);
		
		return $this->__auto_refresh(); 
	}
	################
	
	###############
	function set_isgallery()
	{
		$info = array(
						'tablename'		=>		TABLE_NAME,
						'field_id'		=>		'id',
						'field_display'	=>		'isgallery',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'isgallery'	
					 );
		$this->__set_display_field_on_table($info);
		
		return $this->__auto_refresh(); 
	}
	################
	
	###############
	function set_ordering()
	{
		if (!ALSS)
		{
			return $this->__redirect('index.php');
		}
		
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