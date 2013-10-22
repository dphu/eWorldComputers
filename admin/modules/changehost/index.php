<?php if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));}

//edit FCK
//edit attachment/file on DB

class MYCLASS
{
	private $db = NULL;
	
	public function __construct(&$db)
	{
		$this->db = $db;
	}
	
	public function view()
	{
		//view
		if (($_SERVER['REQUEST_METHOD'] != 'POST') || !isset($_POST))
		{
			return require_once 'views/view.php';
		}
		
		//get host
		$host = IO::getPOST('host');
		if ($host == '')
		{
			ERROR::setError('host', 'Invalid');
			return require_once 'views/view.php';
		}
		$host = str_replace('attachment/image/', '', $host);
		if (substr($host, 0, 1) != '/')
		{
			$host = '/' . $host;
		}
		if (substr($host, strlen($host)-1, 1) != '/')
		{
			$host = $host . '/';
		}
		
		//get rows
		$rows = array();
		__MYMODEL::__doQuery('SHOW TABLES', $this->db);
		$tables = $this->db->fetchRowSet();
		foreach ($tables as $k => $row)
		{
			foreach ($row as $sk => $table)
			{
				if ($this->db->count_records($table))
				{
					$rows[$table] = array();
				}
			}
		}
		unset($tables);
		
		//fill all tables
		foreach ($rows as $table => $item)
		{
			$max = $this->db->count_records($table);
			for ($i=0; $i<$max; $i+=100)
			{
				$rss = __MYMODEL::__doSELECT($this->db, '*', "`{$table}`", NULL, NULL, NULL, "LIMIT {$i}, 100", 'fetchRowSet');
				foreach ($rss as $k => $row)
				{
					$rs = array();
					foreach ($row as $field => $value)
					{
						if (($field == 'id') || (strpos($value, $host.'attachment/image/') !== FALSE))
						{
							$rs[$field] = $value;
						}
					}
					if (count($rs) > 1)
					{
						$item[] = $rs;
					}
				}
			}
			if (count($item))
			{
				$rows[$table] = $item;
			}
			else
			{
				unset($rows[$table]);
			}
		}
		
		//change
		$count = 0;
		foreach ($rows as $table => $item)
		{
			foreach ($item as $k => $row)
			{
				$sets = array();
				foreach ($row as $field => $value)
				{
					if ($field != 'id')
					{
						$value = str_replace($host.'attachment/image/', MYSITEROOT.'attachment/image/', $value);
						$sets[] = "`{$field}` = '{$value}'";
						$count++;
					}
				}
				__MYMODEL::__doUPDATE($this->db, $table, $sets, "WHERE `id` = {$row['id']}", 'LIMIT 1');
			}
		}
		
		//set FCK
		$this->__setFCK();
		
		echo '<script>alert("Changed '.$count.' items");</script>';
		
		return IO::redirect('index.php');
	} 
	
	private function __setFCK()
	{
		if ($f = fopen('../clients/javascript/fckeditor/MaiNgocMySetting_May052009.js', 'w'))
		{
			fwrite($f, "var MYSITEROOT = '".MYSITEROOT."';");
			fclose($f);
		}
		else
		{
			echo '<script type="text/javascript">alert("Error: File \'clients/javascript/fckeditor/MaiNgocMySetting_May052009.js\' is not writable.");</script>';
		}
	}
}

$obj = new MYCLASS($db);
$obj->view();
unset($obj);
?>