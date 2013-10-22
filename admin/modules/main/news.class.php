<?php
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'configs/config.cfg.php';

class News extends BASE_CLASS
{
	private $db;
	private $path = array();
	private $title;
	
	//---------------------- constructor ------------------- //
	public function __construct(&$db)
	{
		$this->db = $db;

	}
	//end function 
	
	// ------ view ---------- //
	public function view()
	{
		global $countKHFAQ;
		
		
		if ($countKHFAQ) {
			$KHFAQ = "<ul style=\"list-style-type:none;\"><li style=\"cursor:pointer; font-size:20px; font-weight:bold; color:#0000ff;\" onclick=\"javascript:window.location.href='index.php?module=faq&function=view';\">* Có {$countKHFAQ} nội dung được gởi đến Admin</li></ul>";
		} else {
			$KHFAQ = '';
		}
		
		//save link
		IO::setBackURL();
		
		//normal
		if (!$countKHFAQ) {
			return require_once 'views/welcome.php';
		}
		
		//co bd
		return require_once 'views/list.php';
	}
	
	// ---- delete bao dong --------------- //
    public function clear()
	{
	   	$type = IO::getID('type');
		$id = IO::getID();
		
		if (!in_array($type, array(1, 2)) || !$id) {
			return $this->__redirect('?');
		}
		
		//update
		$sets = array("`baodong{$type}` = '0'", "`ngaybaodong{$type}` = '0'");
		$where = "WHERE `id` = {$id}";
		$limit = 'LIMIT 1';
		
		__MYMODEL::__doUPDATE($this->db, TABLE_NAME, $sets, $where, $limit);

        //return		
        return $this->__redirect('?');
    }
	
	//get cat text
	protected function __getCatText($table, $id)
	{
		return ($r = __MYMODEL::__doSELECT($this->db, '*', $table, "WHERE `id` = {$id}", NULL, NULL, 'LIMIT 1', 'fetchRow')) ? $r->name_vn : '&nbsp;';
	}
}
//end class

?>