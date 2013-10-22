<?php 
defined('IN_SYSTEM') or die('<hr>');

require_once 'configs/config.cfg.php';
require_once 'models/model.class.php';

class Product extends BASE_CLASS
{
    private $path = array();
	private $title;
	private $db;
	private $extFormView;
	private $extFormViewTCMN;
	private $serialize = _SERIALIZE;

	//da ngon ngu
	private $keyLangList = '';
	private $descriptionLangList = '';
	private $fieldsLangList = '';
	private $field_NAME = NULL;
	private $field_PARTICULAR = NULL;
	private $field_DESC = NULL;
	
    /**
    *@desc Phan trang du lieu
    */
    private $_rowperpage = 30;
    private $_pagerange = 20;
    private $_stylesheet = array(
								'page_cur'	=>  'page_cur',
								'page'      =>  'page',
							);
    private $queryString;// = 'index.php?module=product'; // querystring de truyen vao function phan trang

	private $uploadConfig = array(
        'uploadPath'    =>  UPLOAD_PRODUCT_PATH,
		'maxSize'       =>  2048,
        'imageWidth'	=> '4500',
		'imageHeight'	=> '4500',
		'allowedTypes'	=>	array('jpg','png','gif'),
		'overwrite'     => FALSE,		 
    ); 
	
	/*private $nhayKep = NULL;
	private $nhayDon = NULL;
	
	private $UnnhayKep = NULL;
	private $UnnhayDon = NULL;*/
	   
//================================================	
	public function __construct(&$db)
	{
		$this->db = $db;
		
		/*$this->nhayDon = chr(2);
		$this->nhayKep = chr(1);
		
		$this->UnnhayKep = '\"';
		$this->UnnhayDon = "\'";*/
		
		$this->path[] = '<a href="index.php">Administrator</a>';
        $this->path[] = '<a href="index.php?module='.MODULE_NAME.'"><strong>'.MODULE_DESC.'</strong></a>';
		
		$this->queryString ='index.php?' . $_SERVER['QUERY_STRING'];
		if (0 >= ($page = IO::getID('page'))) {
			$page = 1;
		}
		$s1 = '?page=' . $page;
		$s2 = '&page=' . $page;
		$this->queryString = str_replace($s1, '', $this->queryString);
		$this->queryString = str_replace($s2, '', $this->queryString);
		
		//db
		MODEL::autoCreateTables($this->db);
		
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
		
		//set fields list
		$this->fieldsLangList = MULTI_LANGUAGE::getLangConfigInfo($this->db, TABLE_NAME);

		//auto create fields list
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_NAME, $this->field_PARTICULAR, $this->field_DESC);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_NAME);
		$this->PRO_convertFIELDS($this->field_PARTICULAR);
		$this->PRO_convertFIELDS($this->field_DESC);
		
		//mk
		makeTreeFolder(UPLOAD_PRODUCT_PATH);
		
		//import ext fields
		global $extFormView;
		$this->extFormView = $extFormView;
		
		//global $extFormViewTCMN;
		//$this->extFormViewTCMN = $extFormViewTCMN;
	}

	###############################
	private function PRI_CreateListCatSelection($selected_id = 0, $option_all = true, $get_onchange = true)
	{
		if($get_onchange){
			$event = ' onchange="javascript:window.location.href=\'index.php?module='.MODULE_NAME.'&cat_id=\'+this.value" ';
		} else {
			$event = '';
		}
		
		$s = '<select id="cat_id" name="cat_id" '.$event.' class="content-rows">';
        
		if ($option_all) 
		{
			$s .= '<option value="0" selected="selected">&nbsp;&nbsp;&nbsp;--- Select All ---&nbsp;&nbsp;&nbsp;</option>';
		}	
        
	
		//<!-- main cats lst -->
		
		$rows = __MYMODEL::__doSELECT($this->db, '*', TABLE_CAT_NAME, 'WHERE `parent_id` = 0', NULL, 'ORDER BY `ordering`', NULL, 'fetchRowSet');
		
		for ($i=0; $i<count($rows); $i++) {//main cat
				
			$row = $rows[$i];
				
			$selected = ($row->id == $selected_id) ? 'selected="selected"' : '';
			$name = $row->{"name_{$this->keyLangList[0]}"};
			$s .= "<option value=\"{$row->id}\" {$selected} disabled=\"disabled\" style=\"color:#FF0000; font-weight:bold;\">&nbsp;{$name}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
						
			//<!-- sub cats list -->
				
			STACKSTATIC::push($row);
			while ($item = STACKSTATIC::pop()) { 
				$id = $item->id;
				$level[$id] = !isset($level[$id]) ? 0 : $level[$id];
				if ($items = $this->PRO_GetSubCatsList($id)) {
					for($x=0; $x<count($items); $x++) {
						STACKSTATIC::push($items[$x]);
						$level[$items[$x]->id] = $level[$id]+1;	
					}
				}
				if ($item->parent_id) {
					$subRow = $item;
					$selected = ($subRow->id == $selected_id) ? 'selected="selected"' : '';
					$name = $subRow->{"name_{$this->keyLangList[0]}"};
					$s .= "<option value=\"{$subRow->id}\" {$selected}>&nbsp;".str_repeat('.....', $level[$subRow->id])."{$name}&nbsp;&nbsp;&nbsp;&nbsp;</option>";
				}
			}
			//<!-- end of subs cat list -->
		
		}
		//<!-- end of main cats list -->
		
	 	$s .= '</select>';
		
		return $s;
		
	}	
	//get sub cat list on each parent cat
	protected function PRO_GetSubCatsList($parent_id)
	{
		return __MYMODEL::__doSELECT($this->db, '*', TABLE_CAT_NAME, "WHERE `parent_id` = {$parent_id}", NULL, 'ORDER BY `ordering` DESC, `id` DESC', NULL, 'fetchRowSet');
	}
	//end function
	//==============================================================
	
	
	/* list product */
	public function view()
	{
		
		$this->title = 'List';
		
		#get cat id to filtering
		$cat_id = IO::getID('cat_id');
		
		#create the cat selection
		$cat_selection = $this->PRI_CreateListCatSelection($cat_id);
		
		#phan trang
		if (!$cat_id) {
			$_where = '';
		} else {
			$_where = 'WHERE `cat_id`='.$cat_id;
		}
		$_count_records = $this->db->count_records(TABLE_NAME, $_where);
        $_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_pagerange,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString
        				 );
		$pagelist = $this->__create_pages_number_list($_count_records, $_pageinfo, $this->_stylesheet);
		$_limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]

		#STT
        $stt = $_limit[0] + 1;
		
		#get products list to view
		$rows = MODEL::getDataForViews($this->db, $_where, $_limit, $this->field_NAME, $this->field_PARTICULAR);
		#cur link
		$this->__auto_save_current_link();

		#view
		require 'views/list.php';
	}
	
//==============================================================
	public function insert()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if($this->PRI_DoInsert()){
				return $this->__redirect('index.php?module='.MODULE_NAME.'&cat_id='.IO::getID('cat_id'));
			}	
		}

		$this->title = 'Add';
		
		#get cat id to filtering
		$cat_id = IO::getID('cat_id');
		
		#create the cat selection
		$cat_selection = $this->PRI_CreateListCatSelection($cat_id, false, false);
		
		#form		
		IO::setPOST('id', $this->__auto_get_nextId(TABLE_NAME));
		return require 'views/insert.php';
	}


	##############
	private function PRI_DoInsert()
	{
		//fields & values
		$fields = array();
		$values = array();
		
		//create fields list
		for ($i=0; $i<count($this->keyLangList); $i++) {
			${"{$this->serialize}_{$this->keyLangList[$i]}"} = array();
		}
		
		#get data
		foreach ($_POST as $k => $v) 
		{
			if ($k == 'srcimage') 
			{
				continue;
			}
			if ($k == 'virtualurl')
			{
				$virtualurl = $v;
				continue;
			}
			if ($k == 'id')
			{
				$id = abs(intval($v));
				continue;	
			}
			$prefix = substr($k, 0, 2);
			if (in_array($prefix, $this->keyLangList) && in_array(substr($k, 2, 2), array('_f', '_v'))) {
				$keyType = substr($k, 3, 1);
				$v = IO::getPOST($k); 
				$v = str_replace("\"", "''", $v);
				$v = str_replace("\'", "'", $v);
				IO::setPOST($k, $v);
				$v = str_replace("\\", chr(2), $v);
								
				${"{$this->serialize}_{$prefix}"}['r'.(substr($k, 4, strlen($k)-4))][$keyType] = $v;
			} else {//FCK field
				if (in_array($k, $this->field_DESC)) {
					$v = IO::getPOST($k, '', true); //cac tham so kem theo: ['', true] => get noi dung tu Editor
				} else {//normal field
					$v = IO::getPOST($k);
				}	
				${$k} = $v;
				$fields[] = $k;
				$values[] = $v;
			}	
		}

		//do all ext fields
		for ($i=0; $i<count($this->keyLangList); $i++) 
		{
			$fields[] = "{$this->serialize}_{$this->keyLangList[$i]}";
			$v = ${"{$this->serialize}_{$this->keyLangList[$i]}"}; 
			$v = serialize($v); 
			$v = str_replace("'", chr(1), $v);
			$values[] = $v;
		}

		
		//check validation
		if (!$cat_id) {
			ERROR::setError('cat_id', 'Invalid');
		}
		if ($code == '') {
			ERROR::setError('code', 'Invalid');
		/*} elseif ($this->db->count_records(TABLE_NAME, "TRIM(LOWER(`code`)) = TRIM(LOWER('{$code}'))")) {
			ERROR::setError('code', ERROR_CODE_TEXT);*/
		}
		if (USE_PRICE) {
			if ($price == '') {
				ERROR::setError('price', 'Invalid');
			}
		} 
		
		//is link ?
		//large: 098name
		//thumb: name
		//default: thumb to save
		$image = IO::getPOST('srcimage');
		if (strlen($image)): //is link mode
			if ((strlen($image) > 3) && (substr($image, 0, 3) == '098')) //if large choosen
			{
				//real files
				$realLarge = UPLOAD_PRODUCT_PATH.$image;
				$realThumb = UPLOAD_PRODUCT_PATH.substr($image, 3, strlen($image) - 3);
				
				//if not exist thumb file, make it
				if (!is_file($realThumb) || !file_exists($realThumb))
				{
					@rmdir($realThumb);
					$thumbnail = new Thumbnail();
					$thumbnail->setSourceDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setTargetDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setMaxSize(THUMBNAIL_W, THUMBNAIL_H);
					$prefix = str_replace(' ', '', microtime()); 
					$prefix = str_replace('.', '', $prefix);
					$thumbnail->setNamePrefix($prefix);
					if (!$thumbnail->make($image)) //error create thumb
					{
						ERROR::setError('image', 'Error make thumbnail');
					}
					else //create thumb OK
					{
						//rename to real thumb file
						@rename(UPLOAD_PRODUCT_PATH.$prefix.$image, $realThumb);
						
						//data
						$fields[] = 'image';
						$values[] = str_replace('../', '', $realThumb);	
					}
					unset($thumbnail);
				}
				else //if existing thumb, save to DB
				{
					//data
					$fields[] = 'image';
					$values[] = str_replace('../', '', $realThumb);	
				}
			}
			else //if thumb choosen
			{
				//real files
				$realLarge = UPLOAD_PRODUCT_PATH.'098'.$image;
				$realThumb = UPLOAD_PRODUCT_PATH.$image;

				//if size thumb > config setting, create new thumb and new it's large
				$size = @getimagesize($realThumb);
				if (is_array($size) && count($size) && (($size[0] > THUMBNAIL_W) || ($size[1] > THUMBNAIL_H)))
				{
					$thumbnail = new Thumbnail();
					$thumbnail->setSourceDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setTargetDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setMaxSize(THUMBNAIL_W, THUMBNAIL_H);
					$prefix = str_replace(' ', '', microtime()); 
					$prefix = str_replace('.', '', $prefix);
					$thumbnail->setNamePrefix($prefix);
					if (!$thumbnail->make($image)) //error create thumb
					{
						ERROR::setError('image', 'Error copy to thumbnail');
					}
					else //create thumb OK
					{
						//ext
						$ext = explode('.', $image);
						$ext = '.'.$ext[count($ext)-1];
						
						//new real files
						$realLarge = UPLOAD_PRODUCT_PATH.'098'.$prefix.$ext;
						$realThumb = UPLOAD_PRODUCT_PATH.$prefix.$ext;
						
						//rename to new real thumb
						@rename(UPLOAD_PRODUCT_PATH.$prefix.$image, $realThumb);
					}
					unset($thumbnail);
				}

				//if not exist large, copy from thumb to it
				if (!is_file($realLarge) || !file_exists($realLarge))
				{
					@rmdir($realLarge);
					@copy(UPLOAD_PRODUCT_PATH.$image, $realLarge);
				}
			
				//data
				$fields[] = 'image';
				$values[] = str_replace('../', '', $realThumb);	
			}
		else: //is upload mode
			if ($_FILES['image']['tmp_name'] != '') {
				/* bat dau upload file */
				$upload = new Upload($this->uploadConfig);
				if (!$upload->doUpload('image')) {
					ERROR::setError('image', 'Error Upload ');
					unset($upload);
					return false;
				}
				//up ok
				$uploadData = $upload->data();
				unset ($upload);
				#thumbnail
				$thumbnail = new Thumbnail();
				/* set thu muc nguon */
				$thumbnail->setSourceDir(UPLOAD_PRODUCT_PATH);
				/* set thu muc dich */
				$thumbnail->setTargetDir(UPLOAD_PRODUCT_PATH);
				/* set kich co toi da cua thumbnail */
				$thumbnail->setMaxSize(THUMBNAIL_W, THUMBNAIL_H);
				/* dat name prefix */
				$prefix = str_replace(' ', '', microtime()); 
				$prefix = str_replace('.', '', $prefix);
				$thumbnail->setNamePrefix($prefix);
				/* tao thumb nail */
				if (!$thumbnail->make($uploadData['fileName'])) {
					ERROR::setError('image', 'Error upload');
					unset($thumbnail);
					$this->__removeLargeImage($uploadData['fileName']);
					return false;
				}
				#ok
				unset($thumbnail);
				//ext
				$arr = explode('.', $uploadData['fileName']);
				$ext = '.'.$arr[count($arr)-1];
				//duong dan file sau khi thumbnail
				$file = UPLOAD_PRODUCT_PATH.$prefix.$uploadData['fileName'];
				//file thumbnail can tao ra
				$image = UPLOAD_PRODUCT_PATH.$prefix.$ext;
				//rename
				rename ($file, $image);
				//data
				$fields[] = 'image';
				$values[] = str_replace('../', '', $image);	
				#rename to src to large image
				@rename (UPLOAD_PRODUCT_PATH.$uploadData['fileName'], UPLOAD_PRODUCT_PATH.'098'.$prefix.$ext);
			}
			else
			{
				ERROR::setError('image', 'Chose image');
			}
		endif;
		//end image		
		
		//check virtual url
		if (strlen($virtualurl))
		{
			$virtualurl = 'product/'.$virtualurl;
			__REWRITEURL::AutoCheckDuplicateVirtualURL($this->db, $id, $virtualurl);
		}
		
		//error
		if (ERROR::isError()) {
			return false;
		}
				
		//insert
		MODEL::doInsert($this->db, $fields, $values); 
		
		//insert url
		if (strlen($virtualurl))
		{
			if ($row = __MYMODEL::__doSELECT($this->db, 'id', 'tbl_manualurlsettings', "WHERE (`memberof` = '".TABLE_NAME."') AND (`itemid` = {$id})", NULL, NULL, 'LIMIT 1', 'fetchRow'))
			{
				__MYMODEL::__doUPDATE($this->db, 'tbl_manualurlsettings', array("`virtualurl` = '{$virtualurl}'"), "WHERE `id` = {$row->id}", 'LIMIT 1');
			}
			else
			{
				__MYMODEL::__doINSERT($this->db, 'tbl_manualurlsettings', array('`memberof`', '`itemid`', '`realurl`', '`virtualurl`'), array("'".TABLE_NAME."'", $id, "'".str_replace('{id}', $id, REWRITE_URL_REALPATH_TEMPLATE)."'", "'{$virtualurl}'"));	
			}
		}

		//ok
		return true;
	}
	##############
	
	##############
	private function PRI_DoEdit()
	{
		//id
		if (!$id = IO::getID()) {
			return $this->__redirect($this->__back_url());
		}
		
		//create fields list
		for ($i=0; $i<count($this->keyLangList); $i++) {
			${"{$this->serialize}_{$this->keyLangList[$i]}"} = array();
		}
		
		//field & value
		$fields = array();
		$values = array();
		
		//set
		$set = array();
		
		//old image
		$oldimage = '';
		
		#get data
		foreach ($_POST as $k => $v) 
		{
			if ($k == 'srcimage') 
			{
				continue;
			}
			if ($k == 'oldimage') 
			{
				$oldimage = IO::getPOST($k);
				continue;
			}
			
			if ($k == 'virtualurl')
			{
				$virtualurl = $v;
				continue;
			}
			
			$prefix = substr($k, 0, 2);
			if (in_array($prefix, $this->keyLangList) && in_array(substr($k, 2, 2), array('_f', '_v'))) {
				$keyType = substr($k, 3, 1);
				$v = IO::getPOST($k); 
				$v = str_replace("\"", "''", $v);
				$v = str_replace("\'", "'", $v);
				IO::setPOST($k, $v);
				$v = str_replace("\\", chr(2), $v);
				${"{$this->serialize}_{$prefix}"}['r'.(substr($k, 4, strlen($k)-4))][$keyType] = $v;
			} else {//FCK field
				if (in_array($k, $this->field_DESC)) {
					$v = IO::getPOST($k, '', true); //cac tham so kem theo: ['', true] => get noi dung tu Editor
				} else {//normal field
					$v = IO::getPOST($k);
				}	
				${$k} = $v;
				$fields[] = $k;
				$values[] = $v;
			}	
		}
		
		//do all ext fields
		for ($i=0; $i<count($this->keyLangList); $i++) {
			$fields[] = "{$this->serialize}_{$this->keyLangList[$i]}";
			$v = serialize(${"{$this->serialize}_{$this->keyLangList[$i]}"});
			$v = str_replace("'", chr(1), $v);
			$values[] = $v;
		}
		
		//set to $set
		for ($i=0; $i<count($fields); $i++) {
			$set[] = "`{$fields[$i]}` = '{$values[$i]}'";
		}
		
		//check validation
		if (!$cat_id) {
			ERROR::setError('cat_id', 'Invalid');
		}
		if ($code == '') {
			ERROR::setError('code', 'Invalid');
		/*} elseif ($this->db->count_records(TABLE_NAME, "`id` <> {$id} AND TRIM(LOWER(`code`)) = TRIM(LOWER('{$code}'))")) {
			ERROR::setError('code', ERROR_CODE_TEXT);*/
		} 
		
		//is link ?
		//large: 098name
		//thumb: name
		//default: thumb to save
		$image = IO::getPOST('srcimage');
		if (strlen($image)): //is link mode
			if ((strlen($image) > 3) && (substr($image, 0, 3) == '098')) //if large choosen
			{
				//real files
				$realLarge = UPLOAD_PRODUCT_PATH.$image;
				$realThumb = UPLOAD_PRODUCT_PATH.substr($image, 3, strlen($image) - 3);
				
				//if not exist thumb file, make it
				if (!is_file($realThumb) || !file_exists($realThumb))
				{
					@rmdir($realThumb);
					$thumbnail = new Thumbnail();
					$thumbnail->setSourceDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setTargetDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setMaxSize(THUMBNAIL_W, THUMBNAIL_H);
					$prefix = str_replace(' ', '', microtime()); 
					$prefix = str_replace('.', '', $prefix);
					$thumbnail->setNamePrefix($prefix);
					if (!$thumbnail->make($image)) //error create thumb
					{
						ERROR::setError('image', 'Error make thumbnail');
					}
					else //create thumb OK
					{
						//rename to real thumb file
						@rename(UPLOAD_PRODUCT_PATH.$prefix.$image, $realThumb);
						
						//data
						$set[] = "`image`='".str_replace('../', '', $realThumb)."'";
					}
					unset($thumbnail);
				}
				else //if existing thumb, save to DB
				{
					//data
					$set[] = "`image`='".str_replace('../', '', $realThumb)."'";
				}
			}
			else //if thumb choosen
			{
				//real files
				$realLarge = UPLOAD_PRODUCT_PATH.'098'.$image;
				$realThumb = UPLOAD_PRODUCT_PATH.$image;
				
				//if size thumb > config setting, create new thumb and new it's large
				$size = @getimagesize($realThumb);
				if (is_array($size) && count($size) && (($size[0] > THUMBNAIL_W) || ($size[1] > THUMBNAIL_H)))
				{
					$thumbnail = new Thumbnail();
					$thumbnail->setSourceDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setTargetDir(UPLOAD_PRODUCT_PATH);
					$thumbnail->setMaxSize(THUMBNAIL_W, THUMBNAIL_H);
					$prefix = str_replace(' ', '', microtime()); 
					$prefix = str_replace('.', '', $prefix);
					$thumbnail->setNamePrefix($prefix);
					if (!$thumbnail->make($image)) //error create thumb
					{
						ERROR::setError('image', 'Error copy to thumbnail');
					}
					else //create thumb OK
					{
						//ext
						$ext = explode('.', $image);
						$ext = '.'.$ext[count($ext)-1];
						
						//new real files
						$realLarge = UPLOAD_PRODUCT_PATH.'098'.$prefix.$ext;
						$realThumb = UPLOAD_PRODUCT_PATH.$prefix.$ext;
						
						//rename to new real thumb
						@rename(UPLOAD_PRODUCT_PATH.$prefix.$image, $realThumb);
					}
					unset($thumbnail);
				}
				
				//if not exist large, copy from thumb to it
				if (!is_file($realLarge) || !file_exists($realLarge))
				{
					@rmdir($realLarge);
					@copy(UPLOAD_PRODUCT_PATH.$image, $realLarge);
				}
			
				//data
				$set[] = "`image`='".str_replace('../', '', $realThumb)."'";
			}
		else: //is upload mode
			if ($_FILES['image']['tmp_name'] != '') {
			/* bat dau upload file */
			$upload = new Upload($this->uploadConfig);
			if (!$upload->doUpload('image')) {
				ERROR::setError('image', 'Upload error');
				unset($upload);
				return false;
			}
			//up ok
			$uploadData = $upload->data();
			unset ($upload);
			#thumbnail
			$thumbnail = new Thumbnail();
			/* set thu muc nguon */
			$thumbnail->setSourceDir(UPLOAD_PRODUCT_PATH);
			/* set thu muc dich */
			$thumbnail->setTargetDir(UPLOAD_PRODUCT_PATH);
			/* set kich co toi da cua thumb nail */
			$thumbnail->setMaxSize(THUMBNAIL_W, THUMBNAIL_H);
			/* dat name prefix */
			$prefix = str_replace(' ', '', microtime()); 
			$prefix = str_replace('.', '', $prefix);
			$thumbnail->setNamePrefix($prefix);
			/* tao thumb nail */
			if (!$thumbnail->make($uploadData['fileName'])) {
				ERROR::setError('image', 'Resize error');
				unset($thumbnail);
				return false;
			}
			#ok
			unset($thumbnail);
			//ext
			$arr = explode('.', $uploadData['fileName']);
			$ext = '.'.$arr[count($arr)-1];
			//duong dan file sau khi thumbnail
			$file = UPLOAD_PRODUCT_PATH.$prefix.$uploadData['fileName'];
			//file thumbnail can tao ra
			$image = UPLOAD_PRODUCT_PATH.$prefix.$ext;
			//rename
			@rename ($file, $image); 
			$set[] = "`image`='".str_replace('../', '', $image)."'";	
			#rename src to large img
			
			@rename (UPLOAD_PRODUCT_PATH.$uploadData['fileName'], UPLOAD_PRODUCT_PATH.'098'.$prefix.$ext);
			#xoa 2 file cu~
			if (ALLOW_DELETE_IMAGE_SOURCE_WHEN_DELETE_RECORD)
			{
				if (strtolower('../'.$oldimage) != strtolower(UPLOAD_PRODUCT_PATH.$uploadData['fileName'])) {
					$oldimage = '../'.$oldimage;
					@unlink ($oldimage);
					$olimg = str_replace(UPLOAD_PRODUCT_PATH, UPLOAD_PRODUCT_PATH.'098', $oldimage);
				}
			}	
		}       
		endif;
		 	
		//check virtual url
		if (strlen($virtualurl))
		{
			$virtualurl = 'product/'.$virtualurl;
			__REWRITEURL::AutoCheckDuplicateVirtualURL($this->db, $id, $virtualurl);
		}
		
		//error
		if (ERROR::isError()) 
		{
			return false;
		}
		
		/* update */
		MODEL::doUpdate($this->db, $id, $set);
		
		//update url
		__MYMODEL::__doUPDATE($this->db, 'tbl_manualurlsettings', array("`virtualurl` = '{$virtualurl}'"), "WHERE (`itemid` = {$id}) AND (`memberof` = '".TABLE_NAME."')", 'LIMIT 1');
		
		//ok
		return true;
	}
	##############	
	
//==============================================================
	 public function edit()
	 {
	 	if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if ($this->PRI_DoEdit()) {
				return $this->__redirect($this->__back_url());
			}	
		}
		
		//id
		$id = IO::getID();
		if (!$id)
		{
			return $this->__redirect($this->__back_url());
		}

		#get product info
		if (!ERROR::isError()) {
			if (!MODEL::getDataForEdit($this->db, $id)) {
				return $this->__redirect($this->__back_url());
			}
		}
		
		#create the cat selection
		$cat_selection = $this->PRI_CreateListCatSelection(IO::getPost('cat_id'), false, false);
	
		#view
		//$this->path[] = 'Sản Phẩm';
		$this->title = 'Update';
		
		$this->extFormView = array();
		
		global $extFormView;
		for ($i=0; $i<count($this->keyLangList); $i++) 
		{
			$lang = $this->keyLangList[$i];
			
			$this->extFormView[$lang] = array();
			if (!ERROR::isError())
			{
				$k = "{$this->serialize}_{$this->keyLangList[$i]}"; 
				$v = IO::getPOST($k);
				if (!$array = @unserialize($v))
				{
					for ($r=0; $r<count($extFormView[$lang]); $r++) 
					{
						$array["r{$r}"]['f'] = $extFormView[$lang][$r];
						$array["r{$r}"]['v'] = '';
					}
				}
	
				for ($r=0; $r<count($array); $r++) 
				{
					$record = $array["r{$r}"];
					$this->extFormView[$lang][$r] = array("{$lang}_f{$r}&nbsp;", "{$lang}_v{$r}&nbsp;");
					//F
					IO::setPOST("{$lang}_f{$r}", $array["r{$r}"]['f']);
					//V
					$v = $array["r{$r}"]['v'];
					$v = str_replace(chr(1), "'", $v);
					$v = str_replace(chr(2), "\\\\", $v);
					IO::setPOST("{$lang}_v{$r}", $v);
				}
			}
			else
			{
				for ($r=0; $r<count($extFormView[$lang]); $r++) 
				{
					$array["r{$r}"]['f'] = IO::getPOST("{$lang}_f{$r}");
					$array["r{$r}"]['v'] = IO::getPOST("{$lang}_v{$r}");
					
					$this->extFormView[$lang][$r] = array("{$lang}_f{$r}&nbsp;", "{$lang}_v{$r}&nbsp;");
				}
			}	
		}
		
		//url
		if (!ERROR::isError() && ($virtualurl = __REWRITEURL::__GetBasicVirtualURL($this->db, TABLE_NAME, $id)))
		{
			$virtualurl = substr($virtualurl, strlen('product/'));
			IO::setPOST('virtualurl', $virtualurl);
		}
		
		return require 'views/insert.php';
    }

	#####################
	#xoa cac products iamges theo product id
	function __delete_all_images_product_with_product_id($product_id){
		$sql = "SELECT `image` FROM `".TABLE_IMAGES_NAME."` WHERE `product_id` = " . $product_id;			
		$this->db->query($sql);
		if(!$this->db->numRows()){
			return;
		}
		
		while ($row = $this->db->fetchRow()) {
			@unlink('../' . $row->image);
		}				
		
		$this->db->query("DELETE FROM `".TABLE_IMAGES_NAME."` WHERE `product_id` = " . $product_id);
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
	function set_new()
	{
		$info = array(
							'tablename'		=>		TABLE_NAME,
							'field_id'		=>		'id',
							'field_display'	=>		'new',
							'idlist'		=>		$_POST['idlist'],
							'checkbox_name'	=>		'new'	
						 );
			$this->__set_display_field_on_table($info);
	
		$this->__redirect($_SERVER['HTTP_REFERER']);
	}
	################
	
	function set_spbanchay()
	{
		$info = array(
							'tablename'		=>		TABLE_NAME,
							'field_id'		=>		'id',
							'field_display'	=>		'spbanchay',
							'idlist'		=>		$_POST['idlist'],
							'checkbox_name'	=>		'spbanchay'	
						 );
			$this->__set_display_field_on_table($info);
	
		$this->__redirect($_SERVER['HTTP_REFERER']);
	}
	################
	
	###############
	function set_ordering()
	{
		$info = array(
						'table_name'		=>	TABLE_NAME,
						'id_field'			=>	'id',
						'ordering_field'	=>	'ordering'
					 );
		$this->__auto_set_ordering($info);
	
		$this->__redirect($_SERVER['HTTP_REFERER']);
	}
	################	

	###############
	public function deleteimage()
	{
		#get id
		if(!$id = IO::getID()) {
			return $this->__auto_refresh();
		}	
		
		#delete file
		MODEL::doQuery("SELECT `image` FROM `".TABLE_NAME."` WHERE `id` = {$id} LIMIT 1", $this->db);
		if ($this->db->numRows()) 
		{
			$r = $this->db->fetchRow();
			if (ALLOW_DELETE_IMAGE_SOURCE_WHEN_DELETE_RECORD)
			{
				@unlink('../'.$r->image);
			}
			MODEL::doQuery("UPDATE `".TABLE_NAME."` SET `image` = '' WHERE `id` = {$id} LIMIT 1");
		}
		
		#return
		return $this->__auto_refresh();
	}
	###############

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
				__REWRITEURL::DeleteURL($this->db, TABLE_NAME, $id);
		    }
		}
		$idList = '('.implode(',', $idList).')';	
        
		//delete
		MODEL::doDelete($this->db, $idList);
		
		//done		
        return $this->__redirect($_SERVER['HTTP_REFERER']);
    }
	
	###########################
	protected function PRO_getCountImagesList($product_id)
	{
		return $this->db->count_records(TABLE_IMAGES_NAME, "`product_id` = {$product_id}");
	}
	
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
	
}//end class
?>