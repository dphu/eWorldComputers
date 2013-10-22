<?php if(!defined('IN_SYSTEM')) die('Acces Denied!');

//file config cac thong so cua module
//chi can thay doi tai day

define ('ALLOW_DELETE_IMAGE_SOURCE_WHEN_DELETE_RECORD', FALSE);

//preix
define ('PREFIX', 'thietbi');
define ('MAIN_NAME', 'Products');

//modules name
define ('MODULE_NAME', PREFIX.'-product'); //ten cua module 
define ('MODULE_CAT_NAME', PREFIX.'-pro-cat'); //
define ('MODULE_IMAGES_NAME', MODULE_NAME.'images'); //quan li ds hinh anh kem theo module (neu co)

//module description
define ('MODULE_DESC', 'List Of Products');

//database
define ('TABLE_CAT_NAME', 'tbl_cat_products');
define ('TABLE_NAME', 'tbl_products');
define ('TABLE_IMAGES_NAME', 'tbl_products_images');

//folder
//define ('UPLOAD_PRODUCT_PATH', '../upload/'.PREFIX.'/thumb'); //thu muc chua hinh anh kem theo
define ('UPLOAD_PRODUCT_PATH', '../attachment/image/'); //thu muc chua hinh anh kem theo

//co hien thi hinh chi tiet kem theo hay khong?
define ('USE_IMAGES_LIST_DETAIL', TRUE);

//co hien thi cac cot dac diem SP hay khong?
define ('USE_PARTICULAR', FALSE);

//hien thi phan mo ta sp
define ('USE_DESC', TRUE);

//su dung field don gia SP hay khong?
define ('USE_PRICE', FALSE);

//thumbnail SP
define ('THUMBNAIL_W', 130);
define ('THUMBNAIL_H', 130);

//text ma so (khi nhap dl)
define ('CODE_TEXT_NAME', 'Name');

//error
define ('ERROR_CODE_TEXT', 'Duplicate');

//serialize
define ('_SERIALIZE', 'serialize');

//cau truc hien thi (form view)
define ('TITLE_EXT_FIELDS_VIEW', 'Product Features');
define ('EXT_FIELDS_DESC', 'Feature ');
			  
$extFormView = array(
					'en'	=>	array(
											'Width',
											'Depth',
											'Height',
											'Diameter',
											'',
											'',
											'',
											'',
											'',
											'',
										 ),					 
					  );		
					  
//rewrite url template
define ('REWRITE_URL_REALPATH_TEMPLATE', 'product/{id}');

//site config
define ('PAGE_TITLE_DEFAULT', 'NPC - Products');
define ('META_KEYWORD_DEFAULT', 'NPC,Products');
define ('META_DESCRIPTION_DEFAULT', META_KEYWORD_DEFAULT);

?>