<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

//modules
define ('PREFIX', 'banggia'); //ten cua cat
define ('MODULE_NAME', PREFIX.'images'); //ten cua module 

//cho phep back ve tran category hay khong?
define ('ALB', FALSE);

//title
define ('MODULE_DESC', 'FILES DOWNLOAD MANAGEMENT');
define ('MODULE_TITLE', 'List :: '.MODULE_DESC);
define ('INSERT_TITLE', 'Add new file');

//DB
define ('TABLE_CAT_NAME', 'tbl_'.PREFIX); //table cat
define ('TABLE_NAME', TABLE_CAT_NAME.'_img'); //table luu tru hinh anh

//folder
define ('UPLOAD_IMAGES_PATH', '../upload/'.PREFIX.'/'); //thu muc chua hinh anh

//thumbnail
//define ('THUMBNAIL_WIDTH', 201);
//define ('THUMBNAIL_HEIGHT', 350);

//so luong hinh dc upload cung luc
define ('COUNT_FILES', 5);

//file allow upload
$allowedTypes = array(
						'doc', 
						'ppt', 
						'xls', 
						'docx', 
						'pptx', 
						'xlsx', 
						'pdf',
						'jpg', 
						'gif',
						'txt',
						'rar',
						'zip',
					);	 

?>