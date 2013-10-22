<?php

if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

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
	
	//so luong hinh dc upload cung luc
	private $countFile = COUNT_FILES;
	
	//module
	private $moduleCat = PREFIX;
	private $module = MODULE_NAME;
	
	//DB
	private $tableCatName = TABLE_CAT_NAME;
	private $tableName = TABLE_NAME;
	
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

   	private $uploadConfig = array(
									'uploadPath'    =>  UPLOAD_IMAGES_PATH ,
									'maxSize'       =>  2048,
									'imageWidth'	=> '4500',
									'imageHeight'	=> '4500',
									'allowedTypes'	=>	NULL
								); 
	   	
	
	//---------------------- constructor ------------------- //
	public function __construct(&$db = NULL)
	{
		if (!is_object($db)) 
		{
			global $db;
		}

		global $allowedTypes; 
		$this->uploadConfig['allowedTypes'] = $allowedTypes;
		
		$this->db = $db;
		
		$this->queryString = 'index.php?module=' . $this->module;
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = '<strong>'.MODULE_TITLE.'</strong>';
		
		@mkdir ($this->dirpath);
	}
	
	protected function PRO_GetCatsTitle($id) 
	{
		$sql = "SELECT `title_" . LANG_KEY . "` AS `title` FROM `{$this->tableCatName}` WHERE `id` = {$id} LIMIT 1";
		$this->db->query($sql);
		
		if ($this->db->numRows()) {
			$row = $this->db->fetchRow();
			return $row->title;
		} else {
			return '';
		}
	}
	
	protected function PRI_IsValidCatId($id) 
	{
		$sql = "SELECT `id` FROM `{$this->tableCatName}` WHERE `id` = {$id} LIMIT 1";
		$this->db->query($sql);
		
		return $this->db->numRows() ? true : false;
	}
	
	//--------------------------------- view ---------------------------- //
	public function view()
	{
		//save link
		$this->__auto_save_current_link();
		
		//cat_id
		$cat_id = IO::getID('catid');

		//title
		$catTitle = $this->PRO_GetCatsTitle($cat_id);
		if ($catTitle == '') {
			return $this->__redirect('index.php');
		}
		$this->title = MODULE_TITLE . ' - ' . $catTitle;
				
		//where
		$where = " WHERE `cat_id` = {$cat_id} ";
		
		//paging
		$_count_records = $this->db->count_records($this->tableName, $where);
        $_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_pagerange,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString
        				 );
		$pagelist = $this->__create_pages_number_list($_count_records, &$_pageinfo, $this->_stylesheet, 'Page: ');
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]

		#STT
        $stt = $_limit[0] + 1;
		
		//get data
		$sql = "SELECT 
						* 
				FROM {$this->tableName} 
				{$where} 
				ORDER BY `ordering`
				LIMIT {$_limit[0]}, {$_limit[1]}";
		$this->db->query($sql);
		$found = $this->db->numRows() ? true : false;
		
		//view list
		require "views/list.php";
	}
	
	
	//------------------------------------- insert ----------------------- //
	public function insert()
	{ 
		//cat_id
		$cat_id = IO::getID('catid');

		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert($cat_id)) {
				return $this->__redirect("index.php?module={$this->module}&catid={$cat_id}");
			}
		} 		
		
		//text
		$catTitle = $this->PRO_GetCatsTitle($cat_id);
		if ($catTitle == '') {
			return $this->__redirect('index.php');
		}
		$this->path[] = INSERT_TITLE;
		$this->title = 'Thêm file :: ' . MODULE_DESC . ' :: ' . $catTitle;
        	
		//form		
		return require 'views/insert.php';
	}	
	
	//---------------------------------------- do insert --------------------- //
	private function PRI_DoInsert($cat_id = 0)
	{
		//check valid id
		if (!$this->PRI_IsValidCatId($cat_id)) {
			return $this->__redirect('index.php');
		}
		
		//flag
		$OK = false;
		
		//upload config
		$this->uploadConfig['uploadPath'] = $this->dirpath;
		
		//loop cac file
		for ($i=0; $i<$this->countFile; $i++) :
			//try upload
			if (empty($_FILES["image{$i}"]) || empty($_FILES["image{$i}"]['tmp_name'])) {
				continue;
			}
			//upload instance
			$upload = new Upload($this->uploadConfig);
			if (!$upload->doUpload("image{$i}")) {
				ERROR::setError("image{$i}", $upload->getErrors());
				unset($upload);
				continue;
			}	
			//upload OK
			$uploadData = $upload->data();
			unset($upload);
			//file can co'
			$filename = $uploadData['fileName']; 
			//OK
			$OK = true;
			//insert
			if (!ERROR::isError()) {
				$sql = "INSERT INTO `{$this->tableName}` 
						(
							`id` ,
							`cat_id` ,
							`filename` ,
							`ordering` ,
							`display`
						)
						VALUES 
						(
							NULL , 
							{$cat_id}, 
							'{$filename}', 
							1, 
							1
						)";  
				$this->db->query($sql);	
			}	
		endfor;
		
		if (!$OK) {
			ERROR::setError('image0', 'Chọn file');
			return false;
		}
		
		//return
		return ERROR::isError() ? false : true;
	}
	
	// ------------------------- delete ------------------------------- //
    function delete()
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
		$this->PRI_DeleteAllImagesList(" WHERE `id` IN {$idList} "); 
		
		//delete records
		$this->db->query("DELETE FROM `{$this->tableName}` WHERE `id` IN {$idList}");

        //return		
        return $this->__auto_refresh();
    }
	
	// --------------------- delete image ------------------- //
	private function PRI_DeleteAllImagesList($where = '')
	{
		$sql = "SELECT `filename` FROM `{$this->tableName}` {$where}";			
		$this->db->query($sql);
		
		if ($this->db->numRows()) {
			while ($row = $this->db->fetchRow()) {				
				@unlink($this->dirpath . $row->filename);
				@unlink($this->dirpath . '0986174211' . $row->filename);
			}
		}	
	}
	
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
	
	public function set_title()
	{
		$info = array(
						'table_name'		=>	$this->tableName,
						'id_field'			=>	'id',
						'ordering_field'	=>	'title'
					 );
		$this->__auto_set_ordering($info, 'text');
	
		return $this->__auto_refresh();
	}
	
}
//end class

?>