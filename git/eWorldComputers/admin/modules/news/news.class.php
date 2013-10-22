<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'configs/config.cfg.php';
require_once 'models/model.class.php';

class News extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	
	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_TITLE = NULL;
	private $field_DESCRIPTION = NULL;
	private $field_CONTENT = NULL;
	private $field_FORMCONFIG = NULL;
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
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_TITLE, $this->field_DESCRIPTION, $this->field_CONTENT, $this->field_FORMCONFIG);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_TITLE);
		$this->PRO_convertFIELDS($this->field_DESCRIPTION);
		$this->PRO_convertFIELDS($this->field_CONTENT);
		$this->PRO_convertFIELDS($this->field_FORMCONFIG);
	}
	//end function 
	
	protected function __getCatIsTinh($cat_id)
	{
		return $this->db->count_records(TABLE_CAT_NAME, "WHERE `id` = {$cat_id} AND `istinh` = 1");
	}
	
	################ menu & sub cat
	private function PRI_CreateMenuAndCatNewsComboBox(&$menu_id , &$cat_id, &$comboMenu, &$comboCatNews, &$canAdd, &$count_Menu)
	{
		$canAdd = false;
		$count_Menu = false;
		
		//cb menu
		$comboMenu = '<select name="menu" id="menu" onchange="javascript:window.location.href=\'index.php?module=news&menu=\' + document.getElementById(\'menu\').value">';
		MODEL::doQuery('SELECT * FROM `'.TABLE_GRAND_FATHER_NAME.'` ORDER BY `ordering`', $this->db);
		if ($this->db->numRows()) {
			$count_Menu = true;
			while ($r = $this->db->fetchRow()) {
				if (!$menu_id) {
					$menu_id = $r->id;
				}
				$sel = ($r->id == $menu_id) ? 'selected="selected"' : '';
				$comboMenu .= "<option value='{$r->id}' {$sel} >&nbsp;&nbsp;{$r->{'text_'.$this->keyLangList[0]}}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
			}
		}
		$comboMenu .= '</select>';
		
		//cb cat
		$comboCatNews = '<select name="cat" id="cat" onchange="javascript:window.location.href=\'index.php?module=news&menu=\' + document.getElementById(\'menu\').value + \'&cat=\' + document.getElementById(\'cat\').value;">';
		MODEL::doQuery("SELECT * FROM `".TABLE_CAT_NAME."` WHERE `menu_id` = {$menu_id} ORDER BY `ordering`", $this->db);
		if ($this->db->numRows()) {
			$canAdd = true;
			$subDB = new DB(USER, PASS, DBNAME, HOST);
			$subDB->connect();
			$subDB->set_utf8();
			while ($r = $this->db->fetchRow()) {
				if (!$cat_id) {
					$cat_id = $r->id;
				}
				$sel = ($r->id == $cat_id) ? 'selected="selected"' : '';
				$countSub = $this->__getCountSub($subDB, $r->id);
				$comboCatNews .= "<option value='{$r->id}' {$sel}>&nbsp;&nbsp;{$r->{'name_'.$this->keyLangList[0]}} ({$countSub})&nbsp;&nbsp;&nbsp;&nbsp;</option>";
			}
			unset($subDB);
		}
		$comboCatNews .= '</select>';
	}
	//end function
	
	protected function __getCountSub(&$db, $cat_id)
	{
		return $db->count_records(TABLE_NAME, "WHERE `cat_id` = {$cat_id}");
	}
	
	private function PRI_ReGetCatId(&$menu_id, &$cat_id)
	{
		MODEL::doQuery("SELECT `id` FROM `".TABLE_CAT_NAME."` WHERE `menu_id` = {$menu_id} ORDER BY `ordering`, `id` desc LIMIT 1", $this->db);
		if ($this->db->numRows()) {
			$r = $this->db->fetchRow();
			$cat_id = $r->id;
		}	
	}
	
	private function PRI_GetCatID($id)
	{
		MODEL::doQuery("SELECT `cat_id` FROM `".TABLE_NAME."` WHERE `id`= {$id} LIMIT 1", $this->db);
		if ($this->db->numRows()) {
			$r = $this->db->fetchRow();
			return  $r->cat_id;
		} else {	
			return 0;
		}	
	}
	
	// ------ view ---------- //
	public function view()
	{
		//save link
		IO::setBackURL();
		$_SESSION['newsurl'] = IO::getBackURL();
		
		$menu_id = IO::getID('menu');
		$cat_id = IO::getID('cat');
		
		//combo box
		$this->PRI_CreateMenuAndCatNewsComboBox($menu_id, $cat_id, $cbmn, $cb, $canadd, $count_menu);
		
		//re-get cat
		if ($count_menu && !$canadd) {
			$this->PRI_ReGetCatId($menu_id, $cat_id);
		}
		
		//is tinh
		$isCatTinh = $this->__getCatIsTinh($cat_id);
		
		//where
		$where =  "WHERE `cat_id` = {$cat_id}";
		
		//paging
		$_count_records = $this->db->count_records(TABLE_NAME, $where);
        $_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_pagerange,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString . "&menu={$menu_id}&cat={$cat_id}"
        				 );
		$pagelist = $this->__create_pages_number_list($_count_records, $_pageinfo, $this->_stylesheet, 'Page: ');
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]

		#STT
        $stt = $_limit[0] + 1;
		
		//get data
		$rows = MODEL::getDataForViews($this->db, $where, $_limit);

		//view list
		$this->path[] = '<strong>'.MODULE_DESC_VIEW.'</strong>';
		$this->title = TITLE_VIEW;
		require "views/list.php";
	}
	
	#########################################################################
	private function PRI_GetMenuTextAndCatName($cat_id, &$menutext, &$catname)
	{
		$menutext = '';
		$catname = '';
		
		$sql = "SELECT 
						`p`.`text_{$this->keyLangList[0]}` AS `text` ,
						`c`.`name_{$this->keyLangList[0]}` AS `name`
				FROM `tbl_cat_news` AS `c` 
				LEFT JOIN `tbl_menu` AS `p`
				ON (`c`.`menu_id` = `p`.`id`)
				WHERE `c`.`id` = {$cat_id}
				LIMIT 1";  
		MODEL::doQuery($sql, $this->db);		
		if ($this->db->numRows()) {
			$r = $this->db->fetchRow();
			$menutext = $r->text;
			$catname = $r->name;
			return true;
		} else {
			return false;
		}	
	}
	//end function
	
	public function clearformconfig()
	{
		//clear
		if ($id = IO::getID())
		{
			$sets = array();
			foreach ($this->field_FORMCONFIG as $k => $field)
			{
				$sets[] = "`{$field}` = ''";
			}
			__MYMODEL::__doUPDATE($this->db, TABLE_NAME, $sets, "WHERE `id` = {$id}", 'LIMIT 1');
		}
	
		//refresh
		return $this->__redirect($this->__back_url());
	}
	
	//------------ insert -------------- //
	public function insert()
	{ 
		//submit
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoInsert()) {
				return $this->__redirect($this->__back_url());
			}
		} 		
		
		IO::setPOST('id', $this->__auto_get_nextId(TABLE_NAME));
		
		//cat id
		$cat_id = IO::getID('cat');
		
		//getMenuTextAndCatName
		if (!$this->PRI_GetMenuTextAndCatName($cat_id, $menutext, $catname)) {
			return $this->__redirect('index.php');
		}

		//is tinh
		$isCatTinh = $this->__getCatIsTinh($cat_id);

		//text
		$this->path[] = '<strong>' . MODULE_DESC_INSERT . '</strong>';
		$this->title = TITLE_INSERT . ' :: ' . $menutext . ' :: <u><font color="#ff0000">' . $catname . '</font></u>';
        	
		//form		
		return require 'views/insert.php';
	}
	//end function	
	
	//check duplicate
	private function PRI_DuplicateValue($field, $value, $cat_id = 0, $id = 0)
	{
		if (ALLOW_DUPPLICATE_TITLE)
		{
			return FALSE;
		}
		else
		{		
			MODEL::doQuery("SELECT `id` FROM `".TABLE_NAME."` WHERE `{$field}`='{$value}' AND `cat_id`={$cat_id} AND `id`<>{$id} LIMIT 1", $this->db);
			return $this->db->numRows() ? true : false;
		}
	}
	
	//------- do insert -------- //
	private function PRI_DoInsert()
	{
		//cat id
		if (!$cat_id = IO::getID('cat')) {
			return $this->__redirect('index.php');
		}
		
		if (!$id = abs(intval(IO::getPOST('id')))) {
			return $this->__redirect('index.php');
		}
		
		//get data and check validation
		$titles = array();
		$descriptions = array();
		$contents = array();
		$formconfigs = array();
		for ($i=0; $i<count($this->keyLangList); $i++) {
			$titles[$i] = IO::getPOST($this->field_TITLE[$i]);
			if ($titles[$i] == '') {
				ERROR::setError($this->field_TITLE[$i], EMPTY_TITLE);
			} elseif ($this->PRI_DuplicateValue($this->field_TITLE[$i], $titles[$i], $cat_id)) {
				ERROR::setError($this->field_TITLE[$i], DUPLICATE_TITLE);
			}
			$descriptions[$i] = IO::getPOST($this->field_DESCRIPTION[$i], '', true);
			$contents[$i] = IO::getPOST($this->field_CONTENT[$i], '', true);
			$formconfigs[$i] = IO::getPOST($this->field_FORMCONFIG[$i]);
		}

		//page setting
		$pagetitle = IO::getPOST('pagetitle');
		$metakeyword = IO::getPOST('metakeyword');
		$metadescription = IO::getPOST('metadescription');
		
		//check url
		if ($virtualurl = IO::getPOST('virtualurl'))
		{
			$virtualurl = 'news/'.$virtualurl;
			__REWRITEURL::AutoCheckDuplicateVirtualURL($this->db, $id, $virtualurl);
		}

		//error
		if (ERROR::isError()) 
		{
			return false;
		}
				
		//insert db
		MODEL::doInsert($this->db, $cat_id, $this->field_TITLE, $this->field_DESCRIPTION, $this->field_CONTENT, $this->field_FORMCONFIG, $titles, $descriptions, $contents, $formconfigs, $pagetitle, $metakeyword, $metadescription);			 
		
		__MYMODEL::__doUPDATE($this->db, 'tbl_manualurlsettings', array("`virtualurl` = '{$virtualurl}'"), "WHERE (`memberof` = '".TABLE_NAME."') AND (`itemid` = {$id})", 'LIMIT 1');
		
		//ok
		return true;
	}
	
	// ------- edit ------ //	 
	public function edit()
	{
	 	if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($this->PRI_DoEdit()) {
				return $this->__redirect($this->__back_url());
			}	
		}

		//id
		if (!$id = IO::getID()) {
			return $this->__redirect($this->__back_url());
		}
		
	 	//cat id
		if (!$cat_id = $this->PRI_GetCatID($id)) {
			return $this->__redirect($this->__back_url());
		}
		
		//get Menu Text And Cat Name
		if (!$this->PRI_GetMenuTextAndCatName($cat_id, $menutext, $catname)) {
			return $this->__redirect($this->__back_url());
		}
		
		//is tinh
		$isCatTinh = $this->__getCatIsTinh($cat_id);
		
		//text
		$this->path[] = '<strong>'.MODULE_DESC_EDIT.'</strong>';
		$this->title = TITLE_EDIT . ' :: ' . $menutext . ' :: ' . $catname;
		
		#get info on DB
		if (!ERROR::isError()) {
			if (!MODEL::getDataForEdit($this->db, $id)) {
				return $this->__redirect($this->__back_url());
			}
		}	
		
		//url
		if ($virtualurl = __REWRITEURL::__GetBasicVirtualURL($this->db, TABLE_NAME, $id))
		{
			$virtualurl = substr($virtualurl, strlen('news/'));
			IO::setPOST('virtualurl', $virtualurl);
		}
		
		#view
		return require 'views/insert.php';
    }

	// --------- do edit ------------------- //
	private function PRI_DoEdit()
	{
		if (!$id = IO::getID()) {
			return $this->__redirect('index.php');
		}
		if (!$cat_id = $this->PRI_GetCatID($id)) {
			return $this->__redirect('index.php');
		}
		
		//get data and check validation
		$titles = array();
		$descriptions = array();
		$contents = array();
		$formconfigs = array();
		for ($i=0; $i<count($this->keyLangList); $i++) {
			$titles[$i] = IO::getPOST($this->field_TITLE[$i]);
			if ($titles[$i] == '') {
				ERROR::setError($this->field_TITLE[$i], EMPTY_TITLE);
			} elseif ($this->PRI_DuplicateValue($this->field_TITLE[$i], $titles[$i], $cat_id, $id)) {
				ERROR::setError($this->field_TITLE[$i], DUPLICATE_TITLE);
			}
			$descriptions[$i] = IO::getPOST($this->field_DESCRIPTION[$i], '', true);
			$contents[$i] = IO::getPOST($this->field_CONTENT[$i], '', true);
			if (isset($_SESSION['thuananSMN']) && $_SESSION['thuananSMN'] === true)
			{
				$formconfigs[$i] = IO::getPOST($this->field_FORMCONFIG[$i]);
			}
			else
			{
				$row = __MYMODEL::__doSELECT($this->db, "`{$this->field_FORMCONFIG[$i]}` AS `formconfigs`", TABLE_NAME, "WHERE `id` = {$id}", NULL, NULL, NULL, 'fetchRow');
				$formconfigs[$i] = $row->formconfigs;
			}
		}

		//page setting
		$pagetitle = IO::getPOST('pagetitle');
		$metakeyword = IO::getPOST('metakeyword');
		$metadescription = IO::getPOST('metadescription');

		//check url
		if ($virtualurl = IO::getPOST('virtualurl'))
		{
			$virtualurl = 'news/'.$virtualurl;
			__REWRITEURL::AutoCheckDuplicateVirtualURL($this->db, $id, $virtualurl);
		}
		
		//error
		if (ERROR::isError()) 
		{
			return false;
		}
		
		//update data
		MODEL::doUpdate($this->db, $id, $this->field_TITLE, $this->field_DESCRIPTION, $this->field_CONTENT, $this->field_FORMCONFIG, $titles, $descriptions, $contents, $formconfigs, $pagetitle, $metakeyword, $metadescription);			 
		
		//update url
		__MYMODEL::__doUPDATE($this->db, 'tbl_manualurlsettings', array("`virtualurl` = '{$virtualurl}'"), "WHERE `itemid` = {$id}", 'LIMIT 1');
		
		//ok
		return true;
	}

	// ---- delete --------------- //
    public function delete()
	{
	   	if($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['delete'])) {
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
		
		//delete danh sach hinh anh kem theo neu co
		if ($rows = __MYMODEL::__doSELECT($this->db, "CONCAT('../upload/bds/', `image`) AS `a`, CONCAT('../upload/bds/0986174211', `image`) AS `b`", 'tbl_imgdabds', "WHERE `cat_id` IN {$idList}", NULL, NULL, NULL, 'fetchRowSet')) {
			foreach ($rows as $k => $v) {
				@unlink($v->a);
				@unlink($v->b);
			}
			__MYMODEL::__doDELETE($this->db, 'tbl_imgdabds', "WHERE `cat_id` IN {$idList}", '');
		}
		
		//delete records
		MODEL::doDelete($this->db, $idList);

        //return		
        return $this->__auto_refresh();
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
	public function set_isnew()
	{
		$info = array(
						'tablename'		=>		TABLE_NAME,
						'field_id'		=>		'id',
						'field_display'	=>		'isnew',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'isnew'	
					 );
		$this->__set_display_field_on_table($info);
		
		return $this->__auto_refresh(); 
	}
	################
	
	###############
	public function set_ishidetitle()
	{
		$info = array(
						'tablename'		=>		TABLE_NAME,
						'field_id'		=>		'id',
						'field_display'	=>		'ishidetitle',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'ishidetitle'	
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
		
	protected function __getRealPath($id)
	{
		$url = REWRITE_URL_REALPATH_TEMPLATE;
		$url = str_replace('{id}', $id, $url);
		
		$row = __MYMODEL::__doSELECT($this->db, '*', 'tbl_manualurlsettings', "WHERE (`itemid` = {$id}) AND (`memberof`) = '".TABLE_NAME."'", NULL, NULL, 'LIMIT 1', 'fetchRow');
		if (!$row)
		{
			__MYMODEL::__doINSERT($this->db, 'tbl_manualurlsettings', array('`itemid`', '`memberof`', '`realurl`'), array("{$id}", "'".TABLE_NAME."'", "'{$url}'"), NULL);
		}
				
		return BASEURL.INDEX.$url;
	}
	
	protected function __getVirtualPath($id)
	{
		$notSet = '<span style="color:#ff0000; text-decoration: none;">[not set]</span>';
		if (!$virtualurl = __REWRITEURL::__GetBasicVirtualURL($this->db, TABLE_NAME, $id))
		{
			return $notSet;
		}
		else
		{
			return BASEURL.INDEX.$virtualurl;
		}
	}
	
}
//end class

?>