<?php
//for show thumbnails image or flash
//delete file
//MY~: 06-May-2009 9.26 am 
define ('IN_SYSTEM', 1);

session_start();
error_reporting(false);

require_once '../config/db.php';
require_once '../libs/io/io.class.php';
require_once '../libs/resizeview/resizeview.class.php';

//ajax
require_once '../libs/AJAXSECURITY/AJAXSECURITY.class.php';
if (!AJAXSECURITY::IsSecurity())
{
	die('Invalid');
}

//delete ?
$delete = IO::getPOST('delete');
if ($delete != '')
{
	@unlink($folder = '../attachment/image/'.$delete);
	die('OK');
}

//type
$type = IO::getPOST('type');
if (!in_array($type, array('Image', 'File', 'Flash')))
{
	die('Invalid');
}

//Image
if ($type == 'File')
{
	$type = 'Image';
}

header('content-type: text/html; charset=utf-8');

//folder
$folder = '../attachment/image/';

//info
$listInfo = array();

//MIME
$Image = array('image/jpeg','image/gif','image/jpg','image/png','image/x-png','image/jpe','image/pjpeg');
$Flash = array('application/x-shockwave-flash');

//fill to end
if ($handle = opendir($folder)) 
{
    while (FALSE !== ($fileName = readdir($handle))) 
	{
	    if (!in_array($fileName, array('.', '..'))) 
		{
            if (is_file($folder.$fileName))
			{	
				if (!$size = @getimagesize($folder.$fileName))
				{
					continue;
				}
				if (!isset($size['mime']))
				{	
					continue;
				}
				
				if ((($type == 'Image') && in_array($size['mime'], $Image)) || (($type == 'Flash') && in_array($size['mime'], $Flash)))
				{
					$item = array();
					$item[] = $fileName;
					$item[] = "{$size[0]} x {$size[1]}";
					if ($type == 'Image')
					{
						$item[] = RESIZEVIEW::GET_RESIZE(80, 80, $folder.$fileName);
					}
					else
					{
						$item[] = RESIZEVIEW::GET_RESIZE_FLASH_STYLE(150, 150, $folder.$fileName);
					}					
					$listInfo[] = implode(chr(13), $item);
				}
			}
        }
    }
    closedir($handle);
}

//done
$listInfo = implode(chr(10), $listInfo);
die($listInfo);
?>