<?php 
defined('IN_SYSTEM') or die('<hr>');

require_once 'configs/config.cfg.php';
require_once 'models/model.class.php';

class pro_cat extends BASE_CLASS
{
    var $path = array();
	var $title;    
	var $db;

	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_NAME = NULL;
	private $field_DESCRIPTION = NULL;
	
    /**
    *@desc Phan trang du lieu
    */
    var $_rowperpage = 15;
    var $_rangepage = 4;
    var $_stylesheet = array(
									'page_cur'      =>  'page_cur',
									'page'          =>  'page',
  							  );
    var $queryString = ''; // querystring de truyen vao function phan trang

	public function __construct(&$db){
		$this->db = $db;
		
		PRO_CAT_MODEL::autoCreateTables($this->db);
		
		$this->queryString = 'index.php?module=' . PRO_CAT_MODULE_NAME;
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = '<strong>'.PRO_CAT_MODULE_DESC.'</strong>';
		
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
		
		//set fields list
		$this->fieldsLangList = MULTI_LANGUAGE::getLangConfigInfo($this->db, PRO_CAT_TABLE_NAME);
		
		//auto create fields list
		PRO_CAT_MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_NAME, $this->field_DESCRIPTION);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_NAME);
		$this->PRO_convertFIELDS($this->field_DESCRIPTION);
	}

/************ list ************ */
	public function view()
	{	
		#cur link
		$this->__auto_save_current_link();
		
		$this->path[] = PRO_CAT_MODULE_DESC_VIEW;
		$this->title = PRO_CAT_MODULE_DESC_VIEW;

		//where
		$_where = 'WHERE `parent_id` = 0';

		#phan trang
		$_count_records = $this->db->count_records(PRO_CAT_TABLE_NAME, $_where);
		/*
		$_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_rangepage,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString
        				 );
		$_pagelist = $this->__create_pages_number_list($_count_records, $_pageinfo, $this->_stylesheet, 'Trang: ');
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]
		*/
		
		$_pagelist = NULL;
				
		$_limit = array(0 => 0, 1 => $_count_records);
				
		#get list cat
		//$rows = PRO_CAT_MODEL::getDataForViews($this->db, $_limit, $this->field_NAME);
		$rows = __MYMODEL::__doSELECT($this->db, '*', PRO_CAT_TABLE_NAME, 'WHERE `parent_id` = 0', NULL, 'ORDER BY `ordering`', NULL, 'fetchRowSet');
		
		//stt
		$stt = $_limit[0]+1;

		$bgcolor = array('#ff0000','#ffff00','#ff00ff','#f0f0f0','#f0af0d','#aaee34','#215487','#0014cc','#aaccfe','#998841',);

		__MYMODEL::__doUPDATE($this->db, PRO_CAT_TABLE_NAME, array('`isdf` = 0'), "WHERE `parent_id` = 0", NULL);

		#view
		require_once 'views/list.php';
	}	
//*************************************************

	###############
	public function set_display()
	{
		$info = array(
						'tablename'		=>		PRO_CAT_TABLE_NAME,
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
function set_ordering()
{
	$info = array(
					'table_name'		=>	PRO_CAT_TABLE_NAME,
					'id_field'			=>	'id',
					'ordering_field'	=>	'ordering'
				 );
	$this->__auto_set_ordering($info);

	$this->__redirect($_SERVER['HTTP_REFERER']);
}
################

	##########################
	private function PRI_DoInsert()
	{
		$fields = array();
		$values = array();
		
		for ($i=0; $i<count($this->keyLangList); $i++) 
		{
			//name
			$f = $this->field_NAME[$i];
			$fields[] = "`{$f}`";
			
			$v = IO::getPOST($f);
			$values[] = "'{$v}'";
			
			if ($v == '') {
				ERROR::setError($f, MSG_INVALID);
			} elseif ($this->db->count_records(PRO_CAT_TABLE_NAME, "`{$f}` = '{$v}'")) {
				ERROR::setError($f, MSG_DUPLICATE);
			}
			
			//description
			$f = $this->field_DESCRIPTION[$i];
			$fields[] = "`{$f}`";
			
			$v = IO::getPOST($f, '', true);
			$values[] = "'{$v}'";
		}
		
		//get & check valid...
		$parent_id = IO::getPOST('parent_id');
		$fields[] = '`parent_id`';
		$values[] = $parent_id;
		
		$lim = IO::getPOST('lim', '', true);
		$lim = str_replace('width=\"', 'w=\"', $lim);
		$lim = str_replace('height=\"', 'h=\"', $lim);
		$fields[] = '`lim`';
		$values[] = "'{$lim}'";
		
		//page setting
		$pagetitle = IO::getPOST('pagetitle');
		$fields[] = '`pagetitle`';
		$values[] = "'{$pagetitle}'";
		
		$metakeyword = IO::getPOST('metakeyword');
		$fields[] = '`metakeyword`';
		$values[] = "'{$metakeyword}'";
		
		$metadescription = IO::getPOST('metadescription');
		$fields[] = '`metadescription`';
		$values[] = "'{$metadescription}'";
		
		//url
		$id = abs(intval(IO::getPOST('id')));
		$virtualurl = IO::getPOST('virtualurl');
		if ($virtualurl != '')
		{
			if (!$parent_id)
			{
				$virtualurl = 'by/' . $virtualurl;
			}
			else
			{
				$virtualurl = 'category/' . $virtualurl;
			}
			if ($row = __MYMODEL::__doSELECT($this->db, 'id', 'tbl_manualurlsettings', "WHERE (`memberof` = '".PRO_CAT_TABLE_NAME."') AND (`itemid` = {$id})", NULL, NULL, 'LIMIT 1', 'fetchRow'))
			{
				__MYMODEL::__doUPDATE($this->db, 'tbl_manualurlsettings', array("`virtualurl` = '{$virtualurl}'"), "WHERE `id` = {$row->id}", 'LIMIT 1');
			}
			else
			{
				$realurl = str_replace('{id}', $id, (!$parent_id ? REWRITE_URL_REALPATH_TEMPLATE_ROOT : REWRITE_URL_REALPATH_TEMPLATE));
				__MYMODEL::__doINSERT($this->db, 'tbl_manualurlsettings', array('`memberof`', '`itemid`', '`realurl`', '`virtualurl`'), array("'".PRO_CAT_TABLE_NAME."'", $id, "'{$realurl}'", "'{$virtualurl}'"));	
			}
		}
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//insert
		__MYMODEL::__doINSERT($this->db, PRO_CAT_TABLE_NAME, $fields, $values);
		
		//ok
		return true;
	}
	####################
	
	//////////////////////////////////////////
	public function insert()
	{
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert()) {
				return $this->__redirect($this->queryString); 
			}
		}
		
		$comboBox = $this->PRI_CreateComboBox(IO::getPOST('parent_id'));
		
		$this->path[] = PRO_CAT_MODULE_DESC_NEW;
		$this->title = PRO_CAT_MODULE_DESC_NEW;
        
		IO::setPOST('id', $this->__auto_get_nextId(PRO_CAT_TABLE_NAME));
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
		
		//get & check valid...
		for ($i=0; $i<count($this->keyLangList); $i++) 
		{
			//name
			$f = $this->field_NAME[$i];
			$v = IO::getPOST($f);
			
			$sets[] = "`{$f}` = '{$v}'";
			
			if ($v == '') 
			{
				ERROR::setError($f, MSG_INVALID);
			} elseif ($this->db->count_records(PRO_CAT_TABLE_NAME, "`{$f}` = '{$v}' AND `id` <> {$id}")) {
				ERROR::setError($f, MSG_DUPLICATE);
			}
			
			//description
			$f = $this->field_DESCRIPTION[$i];
			$v = IO::getPOST($f, '', true);
			
			$sets[] = "`{$f}` = '{$v}'";
		}
		
		//get & check valid...
		$parent_id = IO::getPOST('parent_id');
		$sets[] = "`parent_id` = {$parent_id}";
		
		$lim = IO::getPOST('lim', '', true);
		$lim = str_replace('width=\"', 'w=\"', $lim);
		$lim = str_replace('height=\"', 'h=\"', $lim);
		$sets[] = "`lim` = '{$lim}'";
		
		//page settings
		$pagetitle = IO::getPOST('pagetitle');
		$sets[] = "`pagetitle` = '{$pagetitle}'";
		$metakeyword = IO::getPOST('metakeyword');
		$sets[] = "`metakeyword` = '{$metakeyword}'";
		$metadescription = IO::getPOST('metadescription');
		$sets[] = "`metadescription` = '{$metadescription}'";
		
		//url
		$realurl = !$parent_id ? REWRITE_URL_REALPATH_TEMPLATE_ROOT : REWRITE_URL_REALPATH_TEMPLATE;
		$realurl = str_replace('{id}', $id, $realurl);
		$virtualurl = IO::getPOST('virtualurl');
		if (strlen($virtualurl))
		{
			if (!$parent_id)
			{
				$virtualurl = 'by/' . $virtualurl;
			}
			else
			{
				$virtualurl = 'category/' . $virtualurl;
			}
		}
		
		//check dup virtual
		__REWRITEURL::AutoCheckDuplicateVirtualURL($this->db, $id, $virtualurl);
		
		//error
		if (ERROR::isError()) {
			return false;
		}
		
		//update
		__MYMODEL::__doUPDATE($this->db, PRO_CAT_TABLE_NAME, $sets, "WHERE `id` = {$id}", 'LIMIT 1');

		//url
		$sets = array();
		$sets[] = "`realurl` = '{$realurl}'";
		$sets[] = "`virtualurl` = '{$virtualurl}'";
		__MYMODEL::__doUPDATE($this->db, 'tbl_manualurlsettings', $sets, "WHERE (`memberof` = '".PRO_CAT_TABLE_NAME."') AND (`itemid` = {$id})", 'LIMIT 1');

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
			if (!$r = PRO_CAT_MODEL::getDataForEdit($this->db, $id)) {
				return $this->__redirect($this->queryString);
			}
		}	
		
		$comboBox = $this->PRI_CreateComboBox(IO::getPOST('parent_id'), $id);
		
		//url
		if ($row = __REWRITEURL::__GetRow($this->db, PRO_CAT_TABLE_NAME, $id))
		{
			$virtualurl = $row->virtualurl;
			if ($virtualurl)
			{
				//delete by/ category/
				if (substr($virtualurl, 0, strlen('by/')) == 'by/')
				{
					$virtualurl = substr($virtualurl, strlen('by/'));
				}
				elseif (substr($virtualurl, 0, strlen('category/')) == 'category/')
				{
					$virtualurl = substr($virtualurl, strlen('category/'));
				}
				IO::setPOST('virtualurl', $virtualurl);
			}
		}
		
		$this->path[] = PRO_CAT_MODULE_DESC_EDIT;
		$this->title = PRO_CAT_MODULE_DESC_EDIT;
		
		IO::setPOST('id', $id);
		require_once 'views/insert.php';		
	}
	
	//=========================================================
    public function delete()
	{
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['delete'])) {
            return $this->__redirect($_SERVER['HTTP_REFERER']);
        }

        $idList = array(0);
        for ($i=0; $i<count($_POST['delete']); $i++) {
            if ($id = intval($_POST['delete'][$i])) {
				$idList[] = $id;
				//delete rewriteurl
				__REWRITEURL::DeleteURL($this->db, PRO_CAT_TABLE_NAME, $id);
			}
		}	
        $idList = '(' . implode(', ', $idList) . ')'; 
				
		//delete		
		PRO_CAT_MODEL::doDelete($this->db, $idList);	
		
		//done
        return $this->__redirect($_SERVER['HTTP_REFERER']);
    }
//====================================================

	/// count sub products list
	protected function __countSubProducts($cat_id)
	{
		return $this->db->count_records(PRO_CAT_TABLE_PRODUCTS_NAME, "WHERE `cat_id` = {$cat_id}");
	}
	//end fucntion

	//get sub cat list on each parent cat
	protected function PRO_GetSubCatsList($parent_id)
	{
		return __MYMODEL::__doSELECT($this->db, '*', PRO_CAT_TABLE_NAME, "WHERE `parent_id` = {$parent_id}", NULL, 'ORDER BY `ordering`  DESC, `id` DESC', NULL, 'fetchRowSet');
	}
	//end function

	//create combobox only main cat
	private function PRI_CreateComboBox($_parent_id = 0, $_id = 0)
	{
		$_parent_id = intval($_parent_id);
		$_id = intval($_id);
		
		$s = '<select name="parent_id" onchange="javascript:SetRealPath(this.value);">';
        
		$s .= '<option value="0" selected="selected">&nbsp;-------------&nbsp;&nbsp;&nbsp;&nbsp;</option>';
        
	
		//<!-- main cats lst -->
		
		$rows = __MYMODEL::__doSELECT($this->db, '*', PRO_CAT_TABLE_NAME, 'WHERE `parent_id` = 0', NULL, 'ORDER BY `ordering`', NULL, 'fetchRowSet');
		
		for ($i=0; $i<count($rows); $i++) {//main cat
				
			$row = $rows[$i];
				
			$selected = ($row->id == $_parent_id) ? 'selected="selected"' : '';
			$disabled = ($row->id == $_id) ? 'disabled="disabled"' : '';
			$color = ($row->id != $_id) ? 'color:#FF0000;' : '';
			$name = $row->{"name_{$this->keyLangList[0]}"};
			$s .= "<option value=\"{$row->id}\" {$selected} {$disabled} style=\"{$color} font-weight:bold;\">&nbsp;{$name}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
						
			//<!-- sub cats list -->
				
			STACKSTATIC::push($row);
			while ($item = STACKSTATIC::pop()) 
			{ 
				$id = $item->id;
				$level[$id] = !isset($level[$id]) ? 0 : $level[$id]; 
				if ($items = $this->PRO_GetSubCatsList($id)) 
				{
					for($x=0; $x<count($items); $x++) 
					{
						STACKSTATIC::push($items[$x]);
						$level[$items[$x]->id] = $level[$id]+1;	
					}
				}
				if ($item->parent_id) 
				{
					$subRow = $item;
					$selected = ($subRow->id == $_parent_id) ? 'selected="selected"' : '';
					$disabled = (($subRow->id == $_id) || ($level[$id] >= MULTI_LEVEL_CATS)) ? 'disabled="disabled"' : '';
					$name = $subRow->{"name_{$this->keyLangList[0]}"};
					$s .= "<option value=\"{$subRow->id}\" {$selected} {$disabled}>&nbsp;".str_repeat('.....', $level[$subRow->id])."{$name}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
				}
			}
			//<!-- end of subs cat list -->
		
		}
		//<!-- end of main cats list -->
		
	 	$s .= '</select>';
		
		return $s;
	}
	//end function

	###############
	public function set_default()
	{
		$v = explode(',', IO::getPOST('set_default_value'));
		
		if (is_array($v) && (count($v) == 2))
		{
			__MYMODEL::__doUPDATE($this->db, PRO_CAT_TABLE_NAME, array('`isdf` = 0'), "WHERE `parent_id` IN (0, {$v[0]})", NULL);
			__MYMODEL::__doUPDATE($this->db, PRO_CAT_TABLE_NAME, array('`isdf` = 1'), "WHERE `id` = {$v[1]}", 'LIMIT 1');
		}
		
		return $this->__auto_refresh();
	}
	################	
	
	protected function __getRealPath($parent_id, $id)
	{
		$url = !$parent_id ? REWRITE_URL_REALPATH_TEMPLATE_ROOT : REWRITE_URL_REALPATH_TEMPLATE;
		$url = str_replace('{id}', $id, $url);
		
		$row = __MYMODEL::__doSELECT($this->db, '*', 'tbl_manualurlsettings', "WHERE (`itemid` = {$id}) AND (`memberof` = '".PRO_CAT_TABLE_NAME."')", NULL, NULL, 'LIMIT 1', 'fetchRow');
		if (!$row)
		{
			__MYMODEL::__doINSERT($this->db, 'tbl_manualurlsettings', array('`itemid`', '`memberof`', '`realurl`'), array("{$id}", "'".PRO_CAT_TABLE_NAME."'", "'{$url}'"), NULL);
		}
				
		return BASEURL.INDEX.$url;
	}
	
	protected function __getVirtualPath($id)
	{
		$notSet = '<span style="color:#ff0000; text-decoration: none;">[not set]</span>';
		$row = __MYMODEL::__doSELECT($this->db, '*', 'tbl_manualurlsettings', "WHERE (`itemid` = {$id}) AND (`memberof` = '".PRO_CAT_TABLE_NAME."')", NULL, NULL, 'LIMIT 1', 'fetchRow');
		if (!$row)
		{
			return $notSet;
		}
		else
		{
			return $row->virtualurl ? BASEURL.INDEX.$row->virtualurl : $notSet;
		}
	}

}
//end class
?>