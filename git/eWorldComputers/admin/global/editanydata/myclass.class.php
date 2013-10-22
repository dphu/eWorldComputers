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
	
	private $blockid = '';
	
	//---------------------- constructor ------------------- //
	public function __construct(&$db)
	{
		$this->db = $db;
		
		$this->blockid = IO::getKey('blockid');
		
		define('TABLE_NAME', $this->blockid);

		MODEL::autoCreateTables($this->db);
		
		$this->path[] = '<a href="index.php?module=main">Administrator</a>';
        $this->path[] = "<strong>CONTENT BLOCK MANAGERMENT <u>{$this->blockid}</u></strong>";
		
		$this->title = "<strong>CONTENT BLOCK MANAGERMENT <u>{$this->blockid}</u></strong>";
		
		//key list lang & description list lang 
		$this->keyLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'key');
		$this->descriptionLangList =  MULTI_LANGUAGE::getLangInfoList($this->db, 'description');
		
		//set fields list
		$this->fieldsLangList = MULTI_LANGUAGE::getLangConfigInfo($this->db, 'tbl_interface_manager');
		
		//auto create fields list
		MODEL::autoCreateFieldList($this->keyLangList, $this->fieldsLangList, $this->field_DESC);
		
		//convert from string to array
		$this->PRO_convertFIELDS($this->field_DESC);
	}
	
	private function __CheckValidID($id, &$displayBlockID)
	{
		if (!$row = __MYMODEL::__doSELECT($this->db, 'content', 'gf747fdgfsdhgufg7456347bg7', NULL, NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			die('Invalid!');
		}
		
		$ids = explode(chr(13), str_replace(array(chr(32), chr(10)), '', $row->content));
		if (!in_array('*', $ids))
		{
			if (!in_array($id, $ids))
			{
				die('Invalid!');
			}
			$displayBlockID = 'none';
		}
	}
	
	//view list
	public function view()
	{
		if (!ALV)
		{
			die ('Invalid!');
		}
	
		//get db
		$rows = __MYMODEL::__doSELECT($this->db, '*', 'tbl_interface_manager', NULL, NULL, 'ORDER BY `blockid`', NULL, 'fetchRowSet');
		
		//view
		return require 'global/editanydata/list.php';
	}
	
	
	//function edit database
	public function edit()
	{
		$url = ALV ? 'index.php?module=block' : 'index.php';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if ($this->PRI_DoEdit())
			{
				return IO::redirect($url);
			}
		}

		#get info on DB
		if (!$id = IO::getID()) {
			return IO::redirect($url);
		}
		
		$displayBlockID = '';
		$this->__CheckValidID($id, $displayBlockID);
			
		if (!ERROR::isError())
		{	
			if ($row = __MYMODEL::__doSELECT($this->db, '*', 'tbl_interface_manager', "WHERE `id` = {$id}", NULL, NULL, 'LIMIT 1', 'fetchRow')) {
				foreach ($row as $f => $v) {
					IO::setPOST($f, $v);
				}
			} else {
				return IO::redirect($url);
			}
		}
		
		#view
		return require 'global/editanydata/edit.php';
    }
	//end function

	public function insert()
	{
		if (!ALI)
		{
			die ('Invalid!');
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$this->PRI_DoInsert();
			return IO::redirect('index.php?module=block');
		}

		#view
		IO::setPOST('display', '1');
		return require 'global/editanydata/edit.php';
    }

	private function __IsDupVirtualURL(&$virtualurl, &$id = 0)
	{
		if (!strlen(trim($virtualurl)))
		{
			return FALSE;
		}
		
		if (__MYMODEL::__doSELECT($this->db, '*', 'tbl_interface_manager', "WHERE (`virtualurl` = '{$virtualurl}') AND (`id` != {$id})", NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			return TRUE;
		}
		else
		{
			return __MYMODEL::__doSELECT($this->db, '*', 'tbl_manualurlsettings', "WHERE `virtualurl` = '{$virtualurl}'", NULL, NULL, 'LIMIT 1', 'fetchRow');
		}
	}

	// ------------------ do edit ---------------------------------- //
	private function PRI_DoEdit()
	{
		$sets = array();
		
		if (!$id = IO::getID()) {
			return IO::redirect('index.php?module=block');
		}
		
		//default URL
		#get cac gia tri tren form submit & check validation
		foreach ($_POST as $f => $v) 
		{
			if (in_array($f, $this->field_DESC)) 
			{
				${$f} = IO::getPOST($f, '', true);
			} 
			else 
			{
				${$f} = IO::getPOST($f);
			}
			//check valid virtual
			if ($f == 'virtualurl')
			{
				${$f} = str_replace(array(' ', "\'", "\"", ';', '&', '?', "\\", '/'), '-', ${$f});
				if ($this->__IsDupVirtualURL(${$f}, $id))
				{
					ERROR::setError($f, 'Duplicated!');
					return FALSE;
				}
				elseif (strtolower(${$f}) == 'admin')
				{
					ERROR::setError($f, 'Not valid!');
					return FALSE;
				}
			}
			$sets[] = "`{$f}` = '{${$f}}'";
		}
		
		//update
		__MYMODEL::__doUPDATE($this->db, 'tbl_interface_manager', $sets, "WHERE `id` = {$id}", 'LIMIT 1');		
		
		//edit root/.htaccess file
		if (isset($virtualurl))
		{
			$deletedRow = -1;
			$newLine = strlen($virtualurl) ? "RewriteRule ^{$virtualurl} {link}" : '#';
			$str = array();
			$filename = '../.htaccess';
			$content = array();
			foreach (explode(chr(13), str_replace(array(chr(10), chr(13)), chr(13), @file_get_contents($filename))) as $k => $v)
			{
				if (trim($v) != '')
				{
					$content[] = $v;
				}
			}
			for ($i=0; $i<count($content); $i++)
			{	
				if ($i == $deletedRow)
				{
					continue;
				}
				$s = trim($content[$i]);
				if (strlen($s))
				{
					$str[] = $s;
					$tag = '#'.$blockid.' ';
					if ((strlen($s) > strlen($tag)) && (substr($s, 0, strlen($tag)) == $tag))
					{
						$link = substr($s, strlen($tag));
						$link = substr($link, 1);
						$link = substr($link, 0, strlen($link)-1);
						$str[] = str_replace('{link}', $link, $newLine);
						$deletedRow = $i+1;
					}
				}
			}
			if ($deletedRow != -1)
			{
				if ($f = fopen($filename, 'w'))
				{
					fwrite($f, implode(chr(10), $str));
					fclose($f);
				}
			}
		}

		//return 
		return true;
	}
	
	private function PRI_DoInsert()
	{
		$fields = array();
		$values = array();
		
		#get cac gia tri tren form submit & check validation
		foreach ($_POST as $f => $v) 
		{
			if (in_array($f, $this->field_DESC)) 
			{
				${$f} = IO::getPOST($f, '', true);
			} 
			else 
			{
				${$f} = IO::getPOST($f);
			}
			//check valid virtual
			if ($f == 'virtualurl')
			{
				${$f} = str_replace(array(' ', "\'", "\"", ';', '&', '?', "\\", '/'), '-', ${$f});
				if ($this->__IsDupVirtualURL(${$f}))
				{
					ERROR::setError('virtualurl', 'Duplicated!');
					return FALSE;
				}
				elseif (strtolower(${$f}) == 'admin')
				{
					ERROR::setError($f, 'Not valid!');
					return FALSE;
				}
			}
			$fields[] = "`{$f}`";
			$values[] = "'{${$f}}'";
		}
		
		//insert
		__MYMODEL::__doINSERT($this->db, 'tbl_interface_manager', $fields, $values);		
		
		//return 
		return true;
	}
	
	public function set_display()
	{
		if (!ALS)
		{
			die ('Invalid!');
		}
	
		$info = array(
						'tablename'		=>		'tbl_interface_manager',
						'field_id'		=>		'id',
						'field_display'	=>		'display',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'display'	
					 );
		$this->__set_display_field_on_table($info);
		
		return IO::redirect('index.php?module=block');
	}
	
	public function set_ispagesettings()
	{
		$info = array(
						'tablename'		=>		'tbl_interface_manager',
						'field_id'		=>		'id',
						'field_display'	=>		'ispagesettings',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'ispagesettings'	
					 );
		$this->__set_display_field_on_table($info);
		
		return IO::redirect('index.php?module=block');
	}
	
	public function set_iscontentusing()
	{
		$info = array(
						'tablename'		=>		'tbl_interface_manager',
						'field_id'		=>		'id',
						'field_display'	=>		'iscontentusing',
						'idlist'		=>		$_POST['idlist'],
						'checkbox_name'	=>		'iscontentusing'	
					 );
		$this->__set_display_field_on_table($info);
		
		return IO::redirect('index.php?module=block');
	}
	
 	public function delete()
	{
		if (!ALD)
		{
			die ('Invalid!');
		}
		
		
	   	if($_SERVER['REQUEST_METHOD'] != 'POST')	   {
            return IO::redirect('index.php?module=block');
        }

        if(!isset($_POST['delete'])){
            return IO::redirect('index.php?module=block');
        }	
			
		$idList = array(0);
       	for($i=0; $i<count($_POST['delete']); $i++){
            $id = intval($_POST['delete'][$i]);
			if ($id) {
				$idList[] = $id;
		    }
		}	
		$idList = '(' . implode(',', $idList) . ')';
		
		//delete records
		__MYMODEL::__doDELETE($this->db, 'tbl_interface_manager', "WHERE `id` IN {$idList}");
		
        //return		
        return IO::redirect('index.php?module=block');
    }
		
}
//end class

?>