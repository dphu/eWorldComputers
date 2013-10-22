<?php
defined('IN_SYSTEM') or die('<hr>');

require_once 'configs/config.cfg.php';

class MYCLASS extends BASE_CLASS
{
    var $path = array();
	var $title;    
	var $db;
	
	private $required = array('Dealer_Country', 'Dealer_City', 'Dealer_BusinessName', 'Dealer_Address', 'zip');
	
	/**
    *@desc Phan trang du lieu
    */
    var $_rowperpage = 50;
    var $_rangepage = 20;
    var $_stylesheet = array(
									'page_cur'      =>  'page_cur',
									'page'          =>  'page',
  							  );
    var $queryString = ''; // querystring de truyen vao function phan trang

	public function __construct(&$db)
	{
		$this->db = $db;
		
		$this->queryString = 'index.php?module=' . MODULE_NAME;
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = '<strong>'.MODULE_DESC.'</strong>';
		
		if (!isset($_SESSION['doft'])) $_SESSION['doft'] = 'all';
	}

	private function __getLocation(&$Country, &$State, &$City)
	{
		$a = array();
		
		if ($City != '') $a[] = $City;
		if ($State != '') 
		{
			if ($row = __MYMODEL::__doSELECT($this->db, 'name_en', TABLE_STATE_NAME, "WHERE `code` = '{$State}'", NULL, NULL, 'LIMIT 1', 'fetchRow'))
			{
				$a[] = $row->name_en;
			}
			else
			{
				$a[] = $State;
			}
		}
		if ($Country != '') $a[] = $Country;
		
		return implode(', ', $a);
	}
	
	public function deleteonce()
	{
		$id = IO::getPOST('delid');
		__MYMODEL::__doDELETE($this->db, TABLE_NAME, "WHERE `id` = {$id}", 'LIMIT 1');
		
		return $this->__auto_refresh(); 
	}
	
/************ list ************ */
	public function view()
	{	
		#cur link
		$this->__auto_save_current_link();
		
		$this->title = MODULE_VIEW;

		//filter
		if ($doft = IO::getPOST('doft'))
		{
			$_SESSION['doft'] = in_array($doft, array('all', 'in', 'out')) ? $doft : 'all';
		}

		$where = '';
		switch ($_SESSION['doft'])
		{
			case 'in':
				$where = "WHERE `Dealer_Country` = 'USA'";
				break;
			
			case 'out':
				$where = "WHERE `Dealer_Country` <> 'USA'";
				break;	
		}
		
		#phan trang
		$_count_records = $this->db->count_records(TABLE_NAME, $where);
		$_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_rangepage,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString
        				 );
		$_pagelist = $this->__create_pages_number_list($_count_records, $_pageinfo, $this->_stylesheet, 'Page: ');
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); 
				
		$rows = __MYMODEL::__doSELECT($this->db, '*', TABLE_NAME, $where, NULL, 'ORDER BY `Dealer_BusinessName`', "LIMIT {$_limit[0]}, {$_limit[1]}", 'fetchRowSet');
		
		//stt
		$stt = $_limit[0]+1;

		#view
		require_once 'views/list.php';
	}	
//*************************************************

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


	##########################
	private function PRI_DoInsert()
	{
		$fields = array();
		$values = array();
		
		foreach ($_POST as $k => $v) 
		{
			$v = IO::getPOST($k);
			if ($k == 'Dealer_Website')
			{
				
			}
			
			if (in_array($k, $this->required) && ($v == ''))
			{
				ERROR::setERROR($k, MSG_INVALID);
				continue;
			}
			
			$fields[] = "`{$k}`";
			$values[] = "'{$v}'";
		}
		
		
		$this->__checkValidZipCode(IO::getPOST('zip'));
		
		//error
		if (ERROR::isError()) 
		{
			return false;
		}
		
		//insert
		__MYMODEL::__doINSERT($this->db, TABLE_NAME, $fields, $values);
		
		//ok
		return true;
	}
	####################
	
	private function __checkValidZipCode($zipcode)
	{
		if (!__MYMODEL::__doSELECT($this->db, '*', TABLE_ZIP_CODE, "WHERE `ZIPCode` = '{$zipcode}'", NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			ERROR::setERROR('zip', MSG_INVALID);
		}
	}
	
	//////////////////////////////////////////
	public function insert()
	{
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert()) {
				return $this->__redirect($this->queryString); 
			}
		}
		
		if (!ERROR::isError())
		{
			IO::setPOST('Dealer_Country', 'USA');
			IO::setPOST('Dealer_WebSite', 'http://');
			
		}
		
		$this->title = MODULE_NEW;

		return require_once 'views/insert.php';
  	}
	
	##########################
	private function PRI_DoEdit()
	{
		//id
		if (!$id = IO::getID()) {
			return $this->__redirect('index.php');
		}
		
		$sets = array();
		
		foreach ($_POST as $k => $v)
		{
			
			if (in_array($k, $this->required) && ($v == ''))
			{
				ERROR::setERROR($k, MSG_INVALID);
				continue;
			}
			
			$v = IO::getPOST($k);
			$sets[] = "`{$k}` = '{$v}'";
		}
		
		$this->__checkValidZipCode(IO::getPOST('zip'));
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//update
		__MYMODEL::__doUPDATE($this->db, TABLE_NAME, $sets, "WHERE `id` = {$id}", 'LIMIT 1');

		//ok
		return true;
	}
	####################
	
	//***************************************************
    public function edit()
	{	
		#cur link
		$this->__auto_save_current_link();
			
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoEdit()) {
				return $this->__redirect($this->queryString);
			}
		}	
	
		if (!$id = IO::getID()) {
            return $this->__redirect($this->queryString);
        }		
		
		//get data for edit
		if (!ERROR::isError()) {
			if (!$row = __MYMODEL::__doSELECT($this->db, '*', TABLE_NAME, "WHERE `id` = {$id}", NULL, NULL, 'LIMIT 1', 'fetchRow')) {
				return $this->__redirect($this->queryString);
			}
			else
			{
				foreach ($row as $k => $v)
				{
					IO::setPOST($k, $v);
				}
			}
		}	
		
		$this->title = MODULE_EDIT;
		
		require_once 'views/insert.php';		
	}
	
	//=========================================================
    public function delete()
	{
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['delete'])) {
            return $this->__auto_refresh(); 
        }

        $idList = array(0);
        for ($i=0; $i<count($_POST['delete']); $i++) {
            if ($id = intval($_POST['delete'][$i])) {
				$idList[] = $id;
			}
		}	
        $idList = '(' . implode(', ', $idList) . ')'; 
				
		//delete		
		__MYMODEL::__doDELETE($this->db, TABLE_NAME, "WHERE `id` IN {$idList}", NULL);
				
		//done
        return $this->__auto_refresh(); 
    }
//====================================================

	



	private function __createDropdownListState()
	{
		$s = '<select name="Dealer_State" id="Dealer_State" onchange="javascript:showStateCode(this.value);"><option value="" selected="selected"> -- Select Once -- </option>';
		
		if ($rows = __MYMODEL::__doSELECT($this->db, '*', TABLE_STATE_NAME, 'WHERE `display` = 1', NULL, 'ORDER BY `id`', NULL, 'fetchRowSet'))
		{
			$code = IO::getPOST('Dealer_State');
			foreach ($rows as $k => $v)
			{
				$selected = ($code == $v->code) ? 'selected="selected"' : '';
				$s .= "<option value=\"{$v->code}\">&nbsp;&nbsp;{$v->name_en}&nbsp;&nbsp;&nbsp;</option>";		
			}
		}
		
		$s .= '</select>';
		
		return $s;
	}	

}
//end class

$o = new MYCLASS($db);
if(!method_exists($o, $function))
{
    $function = 'view';
}
$o->$function();
unset($o);
?>