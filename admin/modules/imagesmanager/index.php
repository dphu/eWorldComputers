<?php 
//image manager
if(!defined('IN_SYSTEM')){$f='die.php';while(!file_exists($f)||!is_file($f))$f='../'.$f;die(header('Location: '.$f));};

require_once 'configs/config.cfg.php';

class MYCLASS extends BASE_CLASS
{
	private $db = NULL;
	private $uploadConfig = array(
        'uploadPath'    =>  '../attachment/image/',
		'maxSize'       =>  2048,
        'imageWidth'	=> '4500',
		'imageHeight'	=> '4500',
		'allowedTypes'	=>	array('jpg','jpeg','png','gif'),
		'overwrite'     => FALSE,		 
    ); 
	
	private $isPopup = FALSE; 
	
	public function __construct(&$db)
	{
		$this->db = $db;
		
		global $isPopup;
		$this->isPopup = $isPopup;
	}
	
	public function view()
	{
		if (IO::getPOST('sm') == 'sm')
		{
			if ($this->__doUpload())
			{
				return IO::redirect($_SERVER['HTTP_REFERER']);
			}
		}
		
		global $module;
		return require_once 'views/view.php';
	}
	
	private function __doUpload()
	{
		if ($_FILES['image']['tmp_name'] != '') 
		{
			$upload = new Upload($this->uploadConfig);
			if (!$upload->doUpload('image')) 
			{
				ERROR::setError('image', $upload->getErrors());
			}
			unset ($upload);
		}
		else
		{
			ERROR::setError('image', 'Invalid image');
		}
		
		return !ERROR::isError() ? TRUE : FALSE;
	}
}

$obj = new MYCLASS($db);
$obj->view();
unset($obj);
?>