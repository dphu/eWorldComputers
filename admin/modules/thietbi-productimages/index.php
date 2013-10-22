<?php 
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}

require_once 'configs/config.cfg.php';
require_once 'models/model.class.php';

class MYCLASS extends BASE_CLASS
{
	private $path = array();
	private $title;
	private $db;
	
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
									'uploadPath'    =>  UPLOAD_PATH,
									'maxSize'       =>  2048,
									'imageWidth'	=> '3500',
									'imageHeight'	=> '3500',
									'allowedTypes'	=>	array('jpg','png','gif', 'jpeg'),
									'overwrite'     => FALSE,		 
								); 
								
	private $imgs = '';
	   
	//================================================	
	public function __construct(&$db)
	{
		$this->db = $db;
		
		$this->path[] = '<a href="index.php">Administrator</a>';
        $this->path[] = '<a href="index.php?module='.MODULE_NAME.'"><strong>'.MODULE_DESC.'</strong></a>';
		
		$this->queryString ='index.php?' . $_SERVER['QUERY_STRING'];
		if (0 >= ($page = IO::getID('page'))) {
			$page = 1;
		}
		$this->queryString = str_replace('?page=' . $page, '', $this->queryString);
		$this->queryString = str_replace('&page=' . $page, '', $this->queryString);
		
		//DB
		MODEL::autoCreateTables($this->db);
		
		//mk
		makeTreeFolder(UPLOAD_PATH);
	}

	/////////////////////////////////////////////////////
	private function PRI_CreateProductsList($product_id, $view = true)
	{
		$this->imgs = '';
		
		if ($view) 
		{
			$event = 'onchange="javascript:window.location.href=\'index.php?module='.MODULE_NAME.'&product_id=\'+this.value"';
			$text = '&nbsp;&nbsp;&nbsp;--- Select All ---&nbsp;&nbsp;&nbsp;';
		} else {
			$event = 'onchange="javascript:ShowIMG(this.value);"';
			$text = '&nbsp;&nbsp;&nbsp;--------------&nbsp;&nbsp;&nbsp;';
		}
		
		$s = '<select id="product_id" name="product_id" '.$event.' style="font-size:14px; font-weight:bold;"><option value="0" selected="selected">'.$text.'</option>';
		
		$rows = __MYMODEL::__doSELECT($this->db, '`id`, CONCAT(\'&nbsp;&nbsp;&nbsp;\', `name_'.GENERAL_DEFAULT_LANG_CODE.'`, \'&nbsp;&nbsp;(\', `code`, \')&nbsp;&nbsp;&nbsp;\') AS `code`, CONCAT(\'../\', `image`) AS `img`', TABLE_CAT_NAME, NULL, NULL, 'ORDER BY `ordering`, `code`', NULL, 'fetchRowSet');
		if ($rows) 
		{
			foreach ($rows as $k => $v)
			{
				$selected = ($v->id == $product_id) ? 'selected="selected"' : '';
				$s .= "<option value=\"{$v->id}\" {$selected}>{$v->code}</option>";
				
				$this->imgs .= "<img id=\"img_{$v->id}\" src=\"{$v->img}\" style=\"display:none;\" />";
			}	
		}
		
		$s .= '</select>';

		return $s;
	}	
	
	//==============================================================
	public function view()
	{
		#cur link
		$this->__auto_save_current_link();
		
		#get cat id to filtering
		$product_id = IO::getID('product_id');
		
		#create the cat selection
		$comboBox = $this->PRI_CreateProductsList($product_id);
		
		//where
		$where = $product_id ? "WHERE `product_id` = {$product_id}" : '';
		
		#phan trang
		$_count_records = $this->db->count_records(TABLE_NAME, $where);
        $_pageinfo = array(
							'currentpage'   =>  $this->__auto_paging(),
							'rangepage'     =>  $this->_pagerange,
							'rowperpage'    =>  $this->_rowperpage,
							'querystring'   =>  $this->queryString
        				 );
		$pagelist = $this->__create_pages_number_list($_count_records, $_pageinfo, $this->_stylesheet);
		$limit = $this->__auto_set_row_limit($_pageinfo['currentpage'], $this->_rowperpage, 'array'); // return array[0,1]

		#STT
        $stt = $limit[0] + 1;
		
		#get view
		$rows = MODEL::getDataForViews($this->db, $where, $limit);
		
		#view
		$this->path[] = 'Product Images';
        $this->title = 'List';
		require 'views/list.php';
	}
	
	//==============================================================
	public function insert()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($this->PRI_DoIinsert()) {
				return $this->__redirect($this->__back_url());	
			}	
		}	
		
		#get cat id to filtering
		$product_id = !ERROR::isError() ? IO::getID('product_id') : intval(IO::getPost('product_id'));
		
		#create the cat selection
		$comboBox = $this->PRI_CreateProductsList($product_id, false);
				
		#form
		$this->path[] = 'Add new image';
		$this->title = 'Add';
        		
		return require 'views/insert.php';
	}

	##############
	private function PRI_DoIinsert()
	{
		#get product id & check validation
		if (!$product_id = IO::getPost('product_id')) {
			ERROR::setError('product_id', 'Invalid');
		}
		
		//is link mode?
		$image = IO::getPOST('srcimage');
		if (strlen($image)):
			$image = str_replace('../', '', UPLOAD_PATH.$image);
		else: //is upload mode
			if ($_FILES['image']['tmp_name'] != '') {
				/* bat dau upload file */
				$upload = new Upload($this->uploadConfig);
				if (!$upload->doUpload('image')) {
					ERROR::setError('image', 'Upload Error');
				} else {//upload ok
					$uploadData = $upload->data();
					//ext
					$arr = explode('.', $uploadData['fileName']);
					$ext = '.'.$arr[count($arr)-1]; 
					//prefix
					$prefix = str_replace(' ', '', microtime());
					$prefix = str_replace('.', '', $prefix);
					//real file
					$file = UPLOAD_PATH.$uploadData['fileName'];
					//new file
					$image = UPLOAD_PATH.$prefix.$ext;
					//rename
					@rename ($file, $image);
					//set
					$image = str_replace('../', '', $image);
				}
				//free memory
				unset ($upload);
			} else {//not a file
				ERROR::setError('image', 'Upload Error');
			}
		endif;
		
		//error
		if (ERROR::isError()) {
			return false;
		}        	
	
		//insert
		MODEL::doInsert($this->db, $product_id, $image);
		
		//done
		return true;
	}
	##############

#xoa product image theo id
function __delete_products_image_with_id($id)
{
	$sql = "SELECT `image` FROM `".TABLE_NAME."` WHERE `id` = " . $id . " LIMIT 1";			
	$this->db->query($sql);
	if(!$this->db->numRows()){
		return;
	}
	
	$row = $this->db->fetchRow();				
	@unlink('../' . $row->image);
	
	$this->db->query("DELETE FROM `".TABLE_NAME."` WHERE `id` = " . $id);
	
	return;
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

###############
	public function set_alt()
	{
		$info = array(
						'table_name'		=>	TABLE_NAME,
						'id_field'			=>	'id',
						'ordering_field'	=>	'alt'
					 );
		$this->__auto_set_ordering($info, 'text');
	
		return $this->__auto_refresh();
	}
	################	
	
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
		MODEL::doDelete($this->db, $idList);
				
        //done
		return $this->__auto_refresh();
    }
	
	private function __getGrandFatherID($product_id)
	{
		$grandFatherID = 0;
		if ($row = __MYMODEL::__doSELECT($this->db, '*', TABLE_CAT_NAME, "WHERE `id` = {$product_id}", NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			$grandFatherID = $row->cat_id;
		}
		
		return $grandFatherID;
	}


}//end class

$obj = new MYCLASS($db);
if(!method_exists($obj, $function))
{
	$function = 'view';
}
$obj->$function();
unset($obj);
?>