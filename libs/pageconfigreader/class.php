<?php

/* class page config reader 

  maingocmy2003@yahoo.com 15-apr-2009 9.57 am */



if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
}

class PAGECONFIGREADER {

    private $db = NULL;
    private $module = NULL;
    private $function = NULL;
    private $virtualurl = NULL;
    //out

    private $pagetitle = NULL;
    private $metakeyword = NULL;
    private $metadescription = NULL;

    public function __construct(&$db, &$module, &$function) {

        $this->db = $db;

        $this->module = $module;

        $this->function = $function;

        $this->virtualurl = (isset($_GET['virtualurl'])) ? $_GET['virtualurl'] : NULL;



        //get by virtual url

        if ($row = $this->__GetByVirtualURL()) {

            $this->__GetRow($row->memberof, $row->itemid);
        } else {

            $this->{"__Get_{$this->module}"}();
        }
    }

    private function __GetRow($table, $id) {

        $where = !in_array($table, array('tbl_interface_manager')) ? "WHERE `id` * `display` = {$id}" : "WHERE (`blockid` = '{$id}') AND (`display` = 1)";



        if ($row = __MYMODEL::__doSELECT($this->db, '`pagetitle`, `metakeyword`, `metadescription`', "`{$table}`", $where, NULL, NULL, 'LIMIT 1', 'fetchRow')) {

            $this->pagetitle = $row->pagetitle;

            $this->metakeyword = $row->metakeyword;

            $this->metadescription = $row->metadescription;
        }



        return NULL;
    }

    private function __GetByVirtualURL() {

        return ($this->virtualurl !== NULL) ? __REWRITEURL::__GetByVirtualURLWithoutMember($this->db, $this->virtualurl) : NULL;
    }

    //get page title

    public function GetPageTitle() {

        return $this->pagetitle;
    }

    //get meta keyword

    public function GetPageMetaKeywords() {

        return $this->metakeyword;
    }

    //get meta description

    public function GetPageMetaDescriptions() {

        return $this->metadescription;
    }

    /*     * ******* EXT METHODS ************** */

    //furniture gallery

    private function __Get_furnituregallery() {

        $table = in_array($this->function, array('viewbyroot', 'viewbycategory')) ? 'tbl_cat_products' : (in_array($this->function, array('viewproduct')) ? 'product' : NULL);



        return $this->__GetRow($table, IO::getID());
    }

    //default: bloock

    private function __Get_getblock() {

        return $this->__GetRow('tbl_interface_manager', IO::getKey('bid'));
    }

    //press & news

    private function __Get_pressandnews() {

        $table = 'tbl_news';

        if (!$id = IO::getID()) {

            $table = 'tbl_interface_manager';

            $id = '___ADMIN_EDITOR___PRESSANDNEWS_MAINPAGE';
        }



        return $this->__GetRow($table, $id);
    }

    //store locator

    private function __Get_storecatalor() {

        return $this->__GetRow('tbl_interface_manager', '___ADMIN_EDITOR___STORELOCATOR');
    }

    //download bang gia

    private function __Get_banggia() {

        return $this->__GetRow('tbl_interface_manager', '___ADMIN_EDITOR___DOWNLOAD');
    }

    //contact

    private function __Get_contact() {

        return $this->__GetRow('tbl_interface_manager', '___ADMIN_EDITOR___CONTACTUS');
    }

}

?>