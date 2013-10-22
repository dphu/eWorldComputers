<?php

defined('IN_SYSTEM') or die('Access denied!');
#mai ngoc my - 10-10-2007 10:49 AM

class BASE_CLASS {

    var $_idlist = '0';

#detect language
    var $_lang_array = array('vn', 'en');
    var $_lang_default = 'vn';

    function __auto_detect_language($session_lang_name = '') {
        if (@empty($session_lang_name)) {
            $lang = 'lang';
        } else {
            $lang = $session_lang_name;
        }

        if (!isset($_SESSION[$lang]))
            $detected = $this->_lang_default;
        elseif (!in_array($_SESSION[$lang], $this->_lang_array))
            $detected = $this->_lang_default;
        else
            $detected = $_SESSION[$lang];

        return $detected;
    }

////////////////////////////////////////////////////
#security
    function __private_check_security($key, $diemsg) {
        if (isset($_GET[$key])) {
            $s = strtolower($_GET[$key]);
            if (strlen($s) > 1) {
                if (substr($s, 0, 1) == '_') {
                    if (!empty($diemsg)) {
                        die($diemsg);
                        return false;
                    } else {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function __check_security($key = '', $diemsg = 'Access Denied!') {
        if ($key != '') {
            return $this->____private_check_security($key, $diemsg);
        } elseif (isset($_GET) && count($_GET)) {
            foreach ($_GET as $key => $value) {
                $result = $this->__private_check_security($key, $diemsg);
                if (!$result)
                    return false;
            }
        }
        return true;
    }

###############################
#auto get request key

    function __auto_get_key($key, $default_value = '') {
        $value = isset($_GET[$key]) ? $_GET[$key] : $default_value;

        return $value;
    }

////////////////////////////////////////
#auto get request id
    function __auto_get_id($key = 'id') {
        if ($key == '') {
            $key = 'id';
        }

        return intval($this->__auto_get_key($key, 0));
    }

/////////////////////
#redirect
    function __redirect($page) {
        echo "<script type='text/javascript'>document.location.href='" . $page . "'</script>";
    }

/////////////////
#refresh site
    function __refresh($default_page = 'index.php?') {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = $default_page;
        }
        $this->__redirect($url);
    }

///////////////////////
#alert
    /* function __alert($msg = '', $datatype = 'string', $require_script_tag = true, $required_vietnamese_font = true){
      if(!empty($msg)){
      if($required_vietnamese_font){
      $meta = 'document.write(\'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\');';
      }else{
      $meta = '';
      }
      if($require_script_tag){
      $open_script_tag = '<script type="text/javascript">';
      $close_script_tag = '</script>';
      }else{
      $open_script_tag = '';
      $close_script_tag = '';
      }
      if($datatype == 'string'){
      $alert = "alert('".$msg."');";
      }else{
      $alert = "alert(".$msg.");";
      }

      echo $open_script_tag . $meta . $alert . close_script_tag;
      }
      return;
      }
     */
    function __alert($msg) {
        //$meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        //$open_script_tag = '<script type=\"text/javascript\">';
        //$close_script_tag = '//script>';
        //$alert = "alert(\'".$msg."\');";
        //echo $meta . $open_script_tag . $alert . close_script_tag;

        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script type='text/javascript'>alert('" . $msg . "');</script>";
    }

/////////////////////////////	
#format input	
//xu li ki tu ' va " truoc khi update/insert du lieu kieu text vao database
    /* function __format_input($input){
      if (get_magic_quotes_gpc()) {
      return $input;
      }
      if (is_array($input)) {
      foreach ($input as $key => $val) {
      $input[$key] = $this->formatInput($val);
      }

      return $input;
      } else {
      if (get_magic_quotes_gpc()) {
      $input = stripslashes($input);
      }

      $chars = '" \' \\ | } ] { [ ? / > <';
      $chars = explode(' ', $chars);
      $values = array();
      foreach ($chars as $char) {
      $values[] = '&#'.ord($char).';';
      }

      return str_replace($chars, $values, $input);
      }
      } */

/////////////////////
#format output (nguoc lai format input)
    /* function __format_output($output){
      if (is_array($output)) {
      foreach ($output as $key => $val) {
      $output[$key] = $this->formatOutput($val);
      }
      } else {
      $output = str_replace( '"', '&#'.ord('"').';', $output);
      $output = str_replace( "'", "&#".ord("'").";", $output);
      $output = stripslashes($output);
      }

      return $output;
      } */

/////////////////////
#get filesize
    function __getFileSize($path) {
        if (!is_file($path) || !file_exists($path)) {
            return 'unknow';
        }

        $fileSize = @filesize($path);
        $sizeUnit = ' Bytes';

        if ($fileSize > 1024) {
            $fileSize = round($fileSize / 1024, 2);
            $sizeUnit = ' KB';
        }

        if ($fileSize > 1024) {
            $fileSize = round($fileSize / 1024, 2);
            $sizeUnit = ' MB';
        }

        if ($fileSize > 1024) {
            $fileSize = round($fileSize / 1024, 2);
            $sizeUnit = ' GB';
        }

        if ($fileSize > 1024) {
            $fileSize = round($fileSize / 1024, 2);
            $sizeUnit = ' TB';
        }

        return $fileSize . $sizeUnit;
    }

////////////////////////
//dem so luot truy cap site
    /* function __get_visitor($lenspace = 0){
      $q = @mysql_query("CREATE TABLE IF NOT EXISTS `tbl_visitor` (
      `id` int(11) NOT NULL auto_increment,
      `c` int(11) NOT NULL,
      PRIMARY KEY (`id`)
      )
      ENGINE=MyISAM
      DEFAULT CHARSET=latin1
      AUTO_INCREMENT=1");
      if(!isset($_SESSION['visiting']))
      {
      $q = @mysql_query("SELECT `c` FROM `tbl_visitor` LIMIT 1");
      $r = @mysql_num_rows($q);
      if(!$r)
      {
      @mysql_query("INSERT INTO `tbl_visitor` (`id`, `c`) VALUES (NULL , 1)");
      $visitor = 1;
      }
      else
      {
      $result = @mysql_fetch_row($q);
      $visitor = intval($result[0]) + 1;
      @mysql_query("UPDATE `tbl_visitor` SET `c` = " . $visitor);
      }
      $_SESSION['visiting'] = true;
      }
      else //dang duyet site
      {
      $q = @mysql_query("SELECT `c` FROM `tbl_visitor` LIMIT 1");
      $r = @mysql_num_rows($q);
      if(!$r)
      {
      @mysql_query("INSERT INTO `tbl_visitor` (`id`, `c`) VALUES (NULL , 1)");
      $visitor = 1;
      }
      else
      {
      $result = @mysql_fetch_row($q);
      $visitor = intval($result[0]);
      }
      }

      $visitor = strval($visitor);
      while(strlen($visitor)<$lenspace) $visitor = '0' . $visitor;

      return $visitor;
      } */

///////////////////////////////
///////////////////////////////
#paging
#tao ra danh sach cac trang theo kieu << back | 5 | 6 | 7 | 8 | next >>  --> rangepage=4
# total_records: tong so record trong database
# pageinfo = array('currentpage'=>currentpage,	'rangepage'=>rangepage,	'rowperpage'=>rowperpage, 'querystring'=>querystring)
# stylesheet = array('page_cur'=>'ten class current page style sheet', 'page'=>'ten class page style sheet', 'tablewidth'=>'width cua table')
#return: HTML code
############################
#   huong dan su dung:    

    /* vi du:
      $total_records = 100;
      $pageinfo = array(
      'currentpage'=>7,
      'rangepage'=>5,
      'rowperpage'=>4,
      'querystring'=>'index.php?name=sanpham'
      )
      $stylesheet = array(
      'page_cur'=>'ten class current page style sheet',
      'page'=>'ten class page style sheet',
      'tablewidth'=>'width cua table'
      )

      goi ham:
      $r = this->__create_pages_number_list($total_records, &$pageinfo, $stylesheet);
      print($r);

      ket qua thu duoc se la:
      Page: << back | * | * | * | * | * | next >>

      cac link tuong tu se la:
      click *: ---> index.php?name=sanpham&page=*
      click back or next: ---->  1 HTML tuong tu

      ghi chu: "*" la cac so cu the
      tai vi tri "currentpage" khong co link

     */



############################
    function __create_pages_number_list($total_records, &$pageinfo, $stylesheet, $pageName = 'Page: ') {
        if (!$total_records)
            return '';

        $total_pages = ceil($total_records / $pageinfo['rowperpage']);

        if ($pageinfo['currentpage'] > $total_pages)
            $pageinfo['currentpage'] = $total_pages;
        if ($pageinfo['currentpage'] < 1)
            $pageinfo['currentpage'] = 1;

        //$back = (int)(($pageinfo['currentpage']-1)/$pageinfo['rangepage']);
        $back = (((ceil($pageinfo['currentpage'] / $pageinfo['rangepage'])) - 1) * $pageinfo['rangepage']) - $pageinfo['rangepage'] + 1;
        /* $back =$pageinfo['currentpage']; 
          if($pageinfo['currentpage']%$pageinfo['rangepage']!=0){
          $back-=($pageinfo['currentpage']%$pageinfo['rangepage']);
          }
          else{
          //$back-=$pageinfo['currentpage']%$pageinfo['rangepage']+$pageinfo['rangepage'];
          $back-= $pageinfo['rangepage'];
          }
          //$back-=$pageinfo['rangepage'];
          $back++; */
        $min = $back ? ($back + $pageinfo['rangepage']) : 1;
        //$min = $back ? $back  : 1;
        $next = $pageinfo['currentpage'] + $pageinfo['rangepage'];
        while ($next % $pageinfo['rangepage'] != 1)
            $next--;
        if ($next > $total_pages)
            $next = 0;
        $max = $min + $pageinfo['rangepage'] - 1;
        $max = ($max >= $pageinfo['rangepage']) ? $max : $pageinfo['rangepage'];

        $max = ($max <= $total_pages) ? $max : $total_pages;
        //$max = $min+$pageinfo['rangepage']-1;
        $str = $pageName;

        if ($back > 0)
            $str .= '<span>&laquo;<a class="' . $stylesheet['page'] . '" href="' . $pageinfo['querystring'] . '&page=' . $back . '">back</a>&nbsp;</span>';

        $str .= '<span class="' . $stylesheet['page'] . '">&nbsp;</span>';

        for ($i = $min; $i < $max; $i++):
            if ($i == $pageinfo['currentpage']):
                $str .= '<span class="' . $stylesheet['page_cur'] . '">' . $i . '</span><span class="' . $stylesheet['page'] . '">&nbsp;<font color="#000000">|</font>&nbsp;</span>';
            else:
                $str .= '<span class="' . $stylesheet['page'] . '"><a class="' . $stylesheet['page'] . '" href="' . $pageinfo['querystring'] . '&page=' . $i . '" >' . $i . '</a>&nbsp;<font color="#000000">|</font>&nbsp;</span>';
            endif;
        endfor;
        if ($max == $pageinfo['currentpage']):
            $str .= '<span class="' . $stylesheet['page_cur'] . '">' . $max . '</span><span class="' . $stylesheet['page'] . '">&nbsp;';
        else:
            $str .= '<span class="' . $stylesheet['page'] . '"><a class="' . $stylesheet['page'] . '" href="' . $pageinfo['querystring'] . '&page=' . $max . '" >' . $max . '</a>&nbsp;';
        endif;

        if ($next)
            $str .= '<span>&nbsp;<a class="' . $stylesheet['page'] . '" href="' . $pageinfo['querystring'] . '&page=' . $next . '" >next</a>&raquo;</span>';

        //$str = '<table width="' . $stylesheet['tablewidth'] . '" cellspacing="0" cellpadding="0" border="0"><tr><td height="15" align="right" valign="bottom" class="' . $stylesheet['page'] . '" style="padding:5px;">' . $str . '</td></tr></table>';

        $str = '<span class="' . $stylesheet['page'] . '">' . $str . '</span>';

        return $str;
    }

###################

    function __show_popup($url, $name, $w = 450, $h = 450) {
        $s = "javascript:opp('" . $url . "', '" . $name . "', " . $w . ", " . $h . ");";

        return $s;
    }

//////////////////////
#tu dong kiem tra trang hien tai dang dung`, can cu vao request "&$pagekey="
    function __auto_paging($pagekey = '') {
        if (empty($pagekey)) {
            $key = 'page';
        } else {
            $key = $pagekey;
        }

        return intval($this->__auto_get_key($key, 1));
    }

//////////////////////	
#thiet lap gioi han LIMIT trong database (dung cho SELECT SQL khi phan trang)
#tham so:
    #  $currentpage ---> trang hien tai
    #  $rowperpage  ---> so record/1 trang
    #  $typereturn  ---> neu la 'text' se thi se cho ra ket qua theo kieu: " LIMIT 0, 10 ";
    #                    neu la 'array' se thi se cho ra ket qua theo kieu: $arr = array( 
    #																					   0 => 0,
    #																					   1 => 10
    #																					);
    function __auto_set_row_limit($currentpage = 1, $rowperpage = 10, $typereturn = 'text') {
        if (!in_array($typereturn, array('text', 'array'))) {
            $typereturn = 'text';
        }

        $begin = (intval($currentpage) - 1) * intval($rowperpage);
        if ($begin < 0)
            $begin = 0;

        $end = intval($rowperpage);

        if ($typereturn == 'text') {
            return ' LIMIT ' . $begin . ', ' . $end . ' ';
        } else {
            $a = array(
                0 => $begin,
                1 => $end
            );
            return $a;
        }
    }

//////////////////////////
    function __get_config_value($config_name = '', $default_value = '') {
        $q = @mysql_query("CREATE TABLE IF NOT EXISTS `tbl_config` (
  `id` int(11) NOT NULL auto_increment,
  `config_name` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `config_value` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1");

        $sql = "SELECT `config_value` FROM `tbl_config` WHERE `config_name`='" . $config_name . "' LIMIT 1";
        $q = @mysql_query($sql);
        if (@mysql_num_rows($q)) {
            $row = @mysql_fetch_row($q);
            foreach ($row as $key => $value) {
                $ret = $value;
                break;
            }
        } else {
            $ret = $default_value;
        }
        return $ret;
    }

//////////////////////////
    function __set_config_value($config_name = '', $config_value = '', $require_addslashes = false) {
        if (trim($config_name) == '')
            return;

        if ($require_addslashes) {
            $config_name = $this->__format_input($config_name);
            $config_value = $this->__format_input($config_value);
        }

        $q = @mysql_query("CREATE TABLE IF NOT EXISTS `tbl_config` (
  `id` int(11) NOT NULL auto_increment,
  `config_name` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  `config_value` varchar(255) character set utf8 collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1");

        $id = 0;
        $sql = "SELECT `id` FROM `tbl_config` WHERE `config_name`='" . $config_name . "' LIMIT 1";
        $q = @mysql_query($sql);
        if (@mysql_num_rows($q)) {
            $row = @mysql_fetch_row($q);
            foreach ($row as $key => $value) {
                $id = intval($value);
                break;
            }
        }

        if ($id) {
            $sql = "UPDATE `tbl_config` SET `config_value` = '" . $config_value . "' WHERE `id` = " . $id . " LIMIT 1";
        } else {
            $sql = "INSERT INTO `tbl_config` (`id`, `config_name`, `config_value`) 
				VALUES (NULL, '" . $config_name . "', '" . $config_value . "')";
        }
        $q = @mysql_query($sql);
    }

##############################

    function __auto_save_current_link($index_file = '') {
        $_SESSION['current_link'] = $index_file . '?' . @$_SERVER['QUERY_STRING'];
    }

###############################	
##############################

    function __auto_refresh() {
        if (isset($_SESSION['current_link']) && $_SESSION['current_link']) {
            $url = $_SESSION['current_link'];
        } else {
            $url = '?';
        }

        return $this->__refresh($url);
    }

###############################		
###################

    function __back_url() {
        if (isset($_SESSION['current_link']) && $_SESSION['current_link']) {
            $url = $_SESSION['current_link'];
        } else {
            $url = '?';
        }

        return $url;
    }

#####################
#######################
#FCK

    function __create_FCK($name, $width, $height, $value = '') {
        $FCK = new FCKeditor($name);
        $FCK->BasePath = sBasePath;
        $FCK->Config['AutoDetectLanguage'] = false;
        $FCK->Config['DefaultLanguage'] = FCK_LANGUAGE;
        $FCK->Config['ToolbarCanCollapse'] = false;
        $FCK->Value = $value;
        $FCK->Value = str_replace('src="attachment/', 'src="' . MYSITEROOT . 'attachment/', $FCK->Value);
        $FCK->Width = $width;
        $FCK->Height = $height;
        return $FCK->Create();
    }

/////////////////////////
    function __auto_get_nextId($table) {
        $sql = 'SHOW TABLE STATUS LIKE "' . $table . '"';
        $q = @mysql_query($sql);

        if (!@mysql_num_rows($q)) {
            return 0;
        }

        $obj = mysql_fetch_object($q);
        foreach ($obj as $key => $value) {
            if ($key == 'Auto_increment') {
                return intval($value);
            }
        }

        return 0;
    }

////////////////////////////
    function __get_file_extention($filename) {
        if (!$filename)
            return die($this->__alert('Could not get file extention, filename is not a valid!'));

        $s = strrev($filename);
        $a = @explode('.', $s);
        if (!$a || !is_array($a) || count($a) < 2) {
            return die($this->__alert('Could not get file extention, filename is not a valid!'));
        } else {
            return '.' . $a[count($a) - 1];
        }
    }

    /* set thuoc tinh display (0, 1) vao table
      tren form submit can phai co cac thanh phan:
      1. <input type='hidden' id='idlist' value='danh sach cac id cua record, cach nhau bang dau phay (,)' >
      vd: <input type='hidden' id='idlist' value='1,23,123,456' >
      luu y: dung ham __auto_write_idlist() de tao tu dong!!!
      2. cac checkbox dung` de check on/off khi thiet lap display theo cu phap sau
      <input name="display[]" type="checkbox" value="id cua record" <?=($record->display)?'checked="checked"':''?> />
      vd: <input name="display[]" type="checkbox" value="<?=$row->id?>" <?=($row->display)?'checked="checked"':''?> />
      luu y: dung ham __auto_write_checkbox() de tao tu dong!!!
      vd cu phap: __auto_write__checkbox('checkbox_name', $id_trong_record, $field_display_trong_record);
      3. trong table phai co 1 field "display" kieu "INT" chi nhan gia tri 0 hoac 1

      # cac doi so truyen vao ham` gom array():
      $table = 'ten table';
      $field_id = 'ten filed id trong table';
      $field_display = 'ten filed display trong table';
      $idlist = $_POST['idlist'] tren form
      $checkbox = 'ten cua checkbox display tren form';
     */

    function __set_display_field_on_table($info, $checkbox_name = 'display') {
        $tablename = $info['tablename'];
        $field_id = $info['field_id'];
        $field_display = $info['field_display'];
        $idlist = isset($_POST['idlist']) ? $_POST['idlist'] : '';
        if ($idlist == '')
            return;
        $checkbox = $info['checkbox_name'];

        $sql = "UPDATE " . $tablename . " SET " . $field_display . " = 0 WHERE " . $field_id . " IN (" . $idlist . ")";

        $q = @mysql_query($sql);

        if (isset($_POST[$checkbox]) && $_POST[$checkbox]) {
            $idlist = '0';
            for ($i = 0; $i < count($_POST[$checkbox]); $i++) {
                $idlist = ($idlist == '0') ? intval($_POST[$checkbox][$i]) : $idlist . ',' . intval($_POST[$checkbox][$i]);
            }
            $sql = "UPDATE " . $tablename . " SET " . $field_display . " = 1 WHERE " . $field_id . " IN (" . $idlist . ")";
            //die($sql);
            $q = @mysql_query($sql);
        }
    }

/////////////////////////
#set any field 0/1 on table (tuong tu nhu set display, nhung ap dung cho field bat ki)
    function __set_any_field_0_1_on_table($any_info) {
        $info = array(
            'tablename' => $any_info['tablename'],
            'field_id' => $any_info['field_id'],
            'field_display' => $any_info['field_any'],
        );

        $this->__set_display_field_on_table($info, $any_info['checkbox_name']);
    }

///////////////////////
# tu dong tao ra checkbox display tren form (de phuc vu cho cong viec cua ham __set_display_field_on_table() 
    function __auto_write_checkbox($checkbox_name, $value_setting, $field_to_checked) {
        if ($field_to_checked == 1) {
            $checked = 'checked="checked"';
        } else {
            $checked = '';
        }
        $s = '<input name="' . $checkbox_name . '[]" type="checkbox" value="' . $value_setting . '" ' . $checked . ' />';

        return $s;
    }

////////////////////////////
#tu dong tao ra hiden idlist tren form (de phuc vu cho cong viec cua ham __set_display_field_on_table() )
    function __auto_write_idlist() {
        $s = '<input name="idlist" type="hidden" id="idlist" value="' . $this->_idlist . '" />';
        return $s;
    }

////////////////////////////
#tu dong thiet lap danh sach cac idlist (de phuc vu cho cong viec cua ham __set_display_field_on_table() )
    function __auto_add_idlist($value_id) {
        $this->_idlist = ($this->_idlist == '0') ? $value_id : $this->_idlist . ',' . $value_id;
    }

///////////////////
#tao ra text ordering tren form
    function __auto_write_textbox_ordering($id, $value = 0, $style = 'size="2" maxlength="5" style="text-align:center;"', $name = 'ordering') {
        $s = '<input name="' . $name . '[' . $id . ']" type="text" value="' . $value . '" ' . $style . ' />';
        echo($s);
        return $s;
    }

    function __auto_write_textbox_url($id, $value = '', $style = '') {
        $s = '<input name="url[' . $id . ']" align="left" type="text" size="40" value="' . $value . '" ' . $style . '  />';
        echo($s);
        return $s;
    }

    function __auto_write_textbox_urlname($id, $value = '', $style = '') {
        $s = '<input name="urlname[' . $id . ']" align="left" type="text" size="40" value="' . $value . '" ' . $style . '  />';
        echo($s);
        return $s;
    }

    function __auto_set_ordering($info, $typeNumber = 'int') {
        if ($typeNumber == 'text') {
            if (isset($_POST[$info['ordering_field']])) {
                foreach ($_POST[$info['ordering_field']] as $key => $value) {
                    $value;
                    $id = intval($key);
                    $sql = "UPDATE " . $info['table_name'] . " SET " . $info['ordering_field'] . " = '" . $value . "' WHERE " . $info['id_field'] . " = " . $id . " LIMIT 1";
                    $q = @mysql_query($sql);
                }
            }
            return;
        }

        //number
        if (isset($_POST['ordering'])) {
            foreach ($_POST['ordering'] as $key => $value) {
                $ordering = ($typeNumber == 'int') ? intval($value) : floatval($value);
                $id = intval($key);
                $sql = "UPDATE " . $info['table_name'] . " SET " . $info['ordering_field'] . " = " . $ordering . " WHERE " . $info['id_field'] . " = " . $id . " LIMIT 1";
                $q = @mysql_query($sql);
            }
        }
    }

    function __auto_set_url($info) {
        if (isset($_POST['url'])) {
            foreach ($_POST['url'] as $key => $value) {
                $url = $value;
                $id = intval($key);
                $sql = "UPDATE " . $info['table_name'] . " SET " . $info['url_field'] . " = '" . $url . "' WHERE " . $info['id_field'] . " = " . $id . " LIMIT 1";
                $q = @mysql_query($sql);
            }
        }
    }

    function __auto_set_urlname($info) {
        if (isset($_POST['urlname'])) {
            foreach ($_POST['urlname'] as $key => $value) {
                $urlname = $value;
                $id = intval($key);
                $sql = "UPDATE " . $info['table_name'] . " SET " . $info['url_field'] . " = '" . $urlname . "' WHERE " . $info['id_field'] . " = " . $id . " LIMIT 1";
                $q = @mysql_query($sql);
            }
        }
    }

//=================================
    function __auto_write_textbox($name, $id, $value = 0, $style = '') {
        $s = '<input name="' . $name . '[' . $id . ']" type="text" value="' . $value . '" ' . $style . ' />';
        return $s;
    }

    /* == set gia tri cua 1 field kieu so == ~hoa */

    function __auto_set_textbox($info) {
        if (isset($_POST[$info['text_name']])) {
            foreach ($_POST[$info['text_name']] as $key => $value) {
                $value = intval($value);
                $id = intval($key);
                $sql = "UPDATE " . $info['table_name'] . " SET " . $info['text_field'] . " = " . $value . " WHERE " . $info['id_field'] . " = " . $id . " LIMIT 1";
                $q = @mysql_query($sql);
            }
        }
    }

    /* == set gia tri cua 1 field kieu chuoi == ~hoa */

    function __auto_set_text($info) {
        if (isset($_POST[$info['text_name']])) {
            foreach ($_POST[$info['text_name']] as $key => $value) {
                $id = intval($key);
                $sql = "UPDATE " . $info['table_name'] . " SET " . $info['text_field'] . " = '" . $value . "' WHERE " . $info['id_field'] . " = " . $id . " LIMIT 1";
                $q = @mysql_query($sql);
            }
        }
    }

    /**
     * auto get POST value from submited form
     * @param: id, default value
     * @access: private
     * @return: post value
     * */
    function __autoGetPOSTValue($id, $default = '', $forFCK = false, $type = 'any') {
        if (!isset($_POST[$id])) {
            return $default;
        } elseif (!$forFCK) {
            if ($type != 'password') {
                return get_magic_quotes_gpc() ? trim($_POST[$id]) : addslashes(trim($_POST[$id]));
            } else {
                return get_magic_quotes_gpc() ? $_POST[$id] : addslashes(trim($_POST[$id]));
            }
        } else {
            return str_replace('src="' . MYSITEROOT . 'attachment/', 'src="attachment/', trim($_POST[$id]));
        }
    }

//end function

    /**
     * write data to form object
     * @param: id
     * @access: private
     * @return: void
     * */
    function __writeData($id) {
        if (isset($_POST[$id])) {
            echo trim($this->__format_output($_POST[$id]));
        } else {
            echo '';
        }
    }

    //end function	

    /**
     * write Error to form
     * @param: id
     * @access: private
     * @return: void
     * */
    function __writeError($id, $default = '*') {
        $result = $this->__getError($id);
        if ($result != '') {
            echo $result;
        } else {
            echo $default;
        }
    }

    //end function

    /**
     * get error
     * @param: id
     * @access: private
     * @return: string
     * */
    function __getError($id) {
        if (isset($_SESSION['error'][$id]) && !is_null($_SESSION['error'][$id])) {
            return $_SESSION['error'][$id];
        } else {
            return '';
        }
    }

    //end function

    /**
     * set error
     * @param: id, err message
     * @access: private
     * @return: void
     * */
    function __setError($id, $msg) {
        $_SESSION['error'][$id] = $msg;
    }

    //end function

    /**
     * is error ?
     * @param: none
     * @access: private
     * @return: true/false
     * */
    function __isError() {
        if (!isset($_SESSION['error']) || !count($_SESSION['error'])) {
            return false;
        } else {
            return true;
        }
    }

    //end function

    function __format_output($output) {
        if (is_array($output)) {
            foreach ($output as $key => $val) {
                $output[$key] = $this->__format_output($val);
            }
            return $output;
        } else {
            //$output = stripslashes($output);
            $output = str_replace('"', '&#' . ord('"') . ';', $output);
            $output = str_replace("'", "&#" . ord("'") . ";", $output);
            return $output;
        }
    }

    /**
     * check valid format of email
     * @param: email
     * @access: private
     * @return: true / false
     * */
    function __isEmail($email) {
        if (trim($email) == '') {
            return false;
        }

        $arrayValidCharacters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '@', '.', '-', '_',);

        $email = strtolower(trim($email));
        $len = strlen($email);

        #check @
        $pos = strpos($email, '@');
        if ($pos === false) {
            return false;
        }
        if ($pos == 0) {
            return false;
        }
        if ($pos == $len - 1) {
            return false;
        }

        #check .
        $pos = strpos($email, '.');
        if ($pos === false) {
            return false;
        }
        if ($pos == 0) {
            return false;
        }
        if ($pos == $len - 1) {
            return false;
        }
        if (strpos(strrev($email), '.') == 0) {
            return false;
        }

        #. not in front of @ :(
        //if (strpos($email, '.') < strpos($email, '@')) {
        //return false;
        //}
        #check @.
        $pos = strpos($email, '@.');
        if ($pos !== false) {
            return false;
        }

        #check .@
        $pos = strpos($email, '.@');
        if ($pos !== false) {
            return false;
        }

        #check ..
        $pos = strpos($email, '..');
        if ($pos !== false) {
            return false;
        }

        #count the '@' character, just only one!
        $count = 0;
        for ($i = 0; $i < $len; $i++) {
            $char = substr($email, $i, 1);
            if ($char == '@') {
                $count++;
            }
            if ($count > 1) {
                return false;
            }
        }

        #check char list
        for ($i = 0; $i < $len; $i++) {
            $char = substr($email, $i, 1);
            if (!in_array($char, $arrayValidCharacters)) {
                return false;
            }
        }

        //this is a valid email! ^^
        return true;
    }

//end function
    /**
     * is number only
     * @param: s
     * @access: private
     * @return: true/false
     * */

    function __isNumberOnly($s) {
        if (!strlen($s)) {
            return false;
        } else {
            for ($i = 0; $i < strlen($s); $i++) {
                if (!in_array(substr($s, $i, 1), array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'))) {
                    return false;
                }
            }
            return true;
        }
    }

    //end function

    /**
     * convert float number to string
     * */
    function __convertNumToStr($n, $prefix, $phannghin, $thapphan) {
        $s = strval($n);
        $a = explode('.', $s);
        if (isset($a[0])) {
            $s = $prefix . number_format(intval($a[0]), 0, '', $phannghin);
        }
        if (isset($a[1])) {
            $s .= $thapphan . $a[1];
        }

        return $s;
    }

    //end function

    /**
     * convert fields array to string
     * */
    protected function PRO_convertFIELDS(&$fields) {
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
    }

    //end function

    protected function convertFIELDS(&$fields) {
        $this->PRO_convertFIELDS($fields);
    }

}

//end class	
?>