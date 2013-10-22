<?php
//module ABOUT

if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'models/model.class.php';
require_once 'configs/config.cfg.php';

class MYCLASS extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	private $dirpath = UPLOAD_IMAGES_PATH;
	
	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_TITLE = NULL;
	private $field_CONTENT = NULL;
	
	//module
	private $module = MODULE_NAME;
	private $imagesListModuleName = MODULE_IMAGES_NAME;
	
	//DB
	private $tableName = TABLE_NAME;
	private $tableNameImages = TABLE_NAME_IMAGE;
	
	/**
    *@desc Phan trang du lieu
    */
    private $_rowperpage = 10;
    private $_pagerange = 10;
    private $_stylesheet = array(
									'page_cur'	=>  'page_cur',
									'page'      =>  'page',
								);
    private $queryString = ''; // querystring de truyen vao function phan trang

	//---------------------- constructor ------------------- //
	public function __construct(&$db = NULL)
	{
		if (!is_object($db)) {
			global $db;
		}

		$this->db = $db;
		
		MODEL::autoCreateTables($this->db);
		
		$this->queryString = 'index.php?module=' . $this->module;
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = '<strong>'.MODULE_DESC.'</strong>';
		
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
		
		//set fields list
		$this->fieldsLangList = MULTI_LANGUAGE::getLangConfigInfo($this->db, TABLE_NAME);
		
		//auto create fields list
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_TITLE, $this->field_CONTENT);
		
		//convert from string to array
		$this->PRI_convertFIELDS();
	}
	
	//--------------------------------- view ---------------------------- //
	public function view()
	{
		//save link
		$this->__auto_save_current_link();
		
		//paging
		$_count_records = $this->db->count_records($this->tableName);
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
		$rows = MODEL::getDataForViews($this->db, $_limit, $this->field_TITLE);
		
		//view list
		$this->title = 'Danh mục ' . MODULE_DESC;
		require "views/list.php";
	}
	
	//////////
	private function __writeLinkToFile($cat_id)
	{
		//db
		$db = new DB(USER, PASS, DBNAME, HOST);
		$db->connect();
		
		//count
		$count = $db->count_records($this->tableNameImages, " `cat_id` = {$cat_id} ");

		unset($db);
		
		//show text
		if (!$count) {
			$s = '[0]';
			$s .=  " - <a href='index.php?module={$this->imagesListModuleName}&function=insert&catid=".$cat_id."'><b>Thêm mới</b></a>";
		} else {
			$s = "[<b><font color='#FF0000'>{$count}</font></b>]";
			$s .=  " - <a href='index.php?module={$this->imagesListModuleName}&catid=".$cat_id."'><b>Chỉnh sửa</b></a>";
		}
		
		print $s;
	}
	
	//------------------------------------- insert ----------------------- //
	public function insert()
	{ 
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert()) {
				return $this->__redirect('index.php?module='.$this->module);
			}
		} 		
		
		//text
		$this->path[] = 'Thêm mới';
		$this->title = 'Thêm mới :: ' . MODULE_DESC;
        	
		//form		
		return require 'views/insert.php';
	}	
	
	//---------------------------------------- do insert --------------------- //
	private function PRI_DoInsert()
	{
		#get cac gia tri tren form submit & check validation
		$titleData = array();
		$contentData = array();
		for ($i=0; $i<count($this->keyLangList); $i++) {
			//title
			${$this->field_TITLE[$i]} = IO::getPOST($this->field_TITLE[$i]);
			if (${$this->field_TITLE[$i]} == '') {
				ERROR::setError($this->field_TITLE[$i], 'Tiêu đề');
			}
			$titleData[] = "'" . ${$this->field_TITLE[$i]} . "'";
			//content
			${$this->field_CONTENT[$i]} = IO::getPOST($this->field_CONTENT[$i], '', true); // 2 tham so ('', true) dung` de get noi dung tu FCK
			$contentData[] = "'" . ${$this->field_CONTENT[$i]} . "'";
		}
		
		//insert
		if (!$this->__isError()) {
			MODEL::doInsert($this->db, $this->field_TITLE, $titleData, $this->field_CONTENT, $contentData);
		}	
		
		//return
		return $this->__isError() ? false : true;
	}
	
	// ----------------------------- edit ----------------- //	 
	public function edit()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($this->PRI_DoEdit()) {
				return $this->__redirect($this->__back_url());
			}	
		}

	 	#id
		if (!$id = IO::getID()) {
			return $this->__redirect($this->__back_url());
		}	
		
		#//////////////////////
		$this->path[] = 'Sửa đổi';
		$this->title = 'Sửa đổi :: ' . MODULE_DESC;
		
		#get info on DB
		if (!ERROR::isError()) {
			if(!$row = MODEL::getDataForEdit($this->db, $id)) {
				return $this->__redirect($this->__back_url());
			}		
		}	
		
		#view
		return require 'views/insert.php';
    }

	private function PRI_convertFIELDS()
	{
		if (!is_array($this->field_TITLE)) {
			$this->field_TITLE = explode(',', $this->field_TITLE);
		}
		if (!is_array($this->field_CONTENT)) {	
			$this->field_CONTENT = explode(',', $this->field_CONTENT);
		}	
	}

	// ------------------ do edit ---------------------------------- //
	private function PRI_DoEdit()
	{
		#get cac gia tri tren form submit & check validation
		if (!$id = IO::getID()) {
			return $this->__redirect('index.php');
		}
		for ($i=0; $i<count($this->keyLangList); $i++) {
			${$this->field_TITLE[$i]} = IO::getPOST($this->field_TITLE[$i]);
			if (${$this->field_TITLE[$i]} == '') {
				ERROR::setError($this->field_TITLE[$i], 'Tiêu đề');
			}
			${$this->field_CONTENT[$i]} = IO::getPOST($this->field_CONTENT[$i], '', true); //tham so ('', true) dung` de get tu FCK
		}
		
		//update
		if (!ERROR::isError()) {
			$set_title = array();
			$set_content = array();
			for ($i=0; $i<count($this->keyLangList); $i++) {
				$field = $this->field_TITLE[$i];
				$value = ${$this->field_TITLE[$i]};
				$set_title[] = "`{$field}` = '{$value}'";	
				
				$field = $this->field_CONTENT[$i];
				$value = ${$this->field_CONTENT[$i]};
				$set_content[] = "`{$field}` = '{$value}'";	
			}
			$sql = "UPDATE `{$this->tableName}` 
					SET	
						" . implode(', ', $set_title) . ",
						" . implode(', ', $set_content) . "
					WHERE `id` = {$id}
					LIMIT 1";  
			MODEL::doQuery($sql, $this->db);		
		}	
		
		//return 
		return $this->__isError() ? false : true;
	}
	
	// ------------------------- delete ------------------------------- //
    public function delete()
	{
		
	   	if($_SERVER['REQUEST_METHOD'] != 'POST')	   {
            return $this->__auto_refresh();
        }

        if(!isset($_POST['delete'])){
            return $this->__auto_refresh();
        }	
			
		$idList = array(0);
       	for($i=0; $i<count($_POST['delete']); $i++){
            $id = intval($_POST['delete'][$i]);
			if ($id) {
				$idList[] = $id;
		    }
		}	
		$idList = '(' . implode(',', $idList) . ')';
		
		//delete images
		MODEL::doDeleteImagesList($this->db, "WHERE `id` IN {$idList}", $this->dirpath);
		
		//delete records
		MODEL::doDelete($this->db, "WHERE `id` IN {$idList}");
		
        //return		
        return $this->__auto_refresh();
    }
	
	###############
	public function set_display()
	{
		$info = array(
						'tablename'		=>		$this->tableName,
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
						'table_name'		=>	$this->tableName,
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