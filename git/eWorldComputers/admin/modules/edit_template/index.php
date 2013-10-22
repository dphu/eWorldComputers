<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};
class MYCLASS
{
	public function __construct(&$db)
	{
		if (!$id = trim(IO::getKey('title')))
		{
			die('Invalid!');
		}
		
		//configs
		if (!$row = __MYMODEL::__doSELECT($db, 'content', 'admineditordesign_manager', NULL, NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			die('Invalid!');
		}
		$ids = explode(chr(13), str_replace(array(chr(32), chr(10)), '', $row->content));

		//check permission
		if (!in_array($id, $ids))
		{
			die('Invalid!');
		}
		
		//get tenplate
		if (!$row = __MYMODEL::__doSELECT($db, '*', 'tbl_interface_manager', "WHERE (`blockid` = '{$id}') AND (`display` = 1)", NULL, NULL, 'LIMIT 1', 'fetchRow'))
		{
			die('Invalid!');
		}
		else
		{		
			foreach ($row as $k => $v)
			{
				if (!in_array($k, array('id', 'blockid', 'display')) && $v)
				{
					echo $v;
					break;	
				}
			}
		}
	}
}
$obj = new  MYCLASS($db);
unset($obj);
;?>