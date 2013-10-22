<?php
defined('IN_SYSTEM') or die('<hr>');

class account extends BASE_CLASS
{
	private $_db = null;
	private $_data = null;
	private $_toplinktext = '<span class="content-path">Administration &raquo; Change Username and Password</span><hr size=1>';
	
	public function __construct(&$db)
	{
		$this->_db = $db;
	}
	
	public function changepass()
	{
		//get info
		$sql="select * from `tbl_admin` order by `id` DESC limit 1";
		$this->_db->query($sql);
		if($this->_db->numRows())
		{
			$this->_data = $this->_db->fetchRow();
			
			require_once 'views/changepass.php';
		}
		else
		{
			echo 'No info!';
		}
	}
	
}//end class

?>