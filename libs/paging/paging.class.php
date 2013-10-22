<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

/**
 * author: maingocmy2003@yahoo.com
 * paging...
 * */
class PAGING {

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

//for URL
    function createPageNumberList($total_records, &$pageinfo, $pageName = 'Page: ', &$otherInfo = NULL) {
        if (!$total_records)
            return '';

        $pageinfo['currentpage'] = PAGING::getCurrentPageRewriteURL();

        //other info
        if (!isset($otherInfo['laquo'])) {
            $otherInfo['laquo'] = '&laquo';
        }
        if (!isset($otherInfo['raquo'])) {
            $otherInfo['raquo'] = '&raquo';
        }
        if (!isset($otherInfo['back'])) {
            $otherInfo['back'] = 'back';
        }
        if (!isset($otherInfo['next'])) {
            $otherInfo['next'] = 'next';
        }
        if (!isset($otherInfo['pageDec'])) {
            $otherInfo['pageDec'] = '';
        }
        if (!isset($otherInfo['alwayPageDec'])) {
            $otherInfo['alwayPageDec'] = FALSE;
        }
        if (!isset($otherInfo['pageInc'])) {
            $otherInfo['pageInc'] = '';
        }
        if (!isset($otherInfo['alwayPageInc'])) {
            $otherInfo['alwayPageInc'] = FALSE;
        }
        if (!isset($otherInfo['pageSeparator'])) {
            $otherInfo['pageSeparator'] = '&nbsp;|&nbsp;';
        }
        if (!isset($otherInfo['template'])) {
            $otherInfo['template'] = '{pageName} {laquo} {pageBack} {pageDec} {pageList} {pageInc} {pageNext} {raquo}';
        }

        //result
        $result['pageName'] = "<span class=\"page_label\">{$pageName}</span>";
        $result['laquo'] = $otherInfo['laquo'];
        $result['raquo'] = $otherInfo['raquo'];

        $total_pages = intval(ceil($total_records / $pageinfo['rowperpage']));
        $pageinfo['total_pages'] = $total_pages;

        if ($pageinfo['currentpage'] > $total_pages)
            $pageinfo['currentpage'] = $total_pages;
        if ($pageinfo['currentpage'] < 1)
            $pageinfo['currentpage'] = 1;

        $back = (((ceil($pageinfo['currentpage'] / $pageinfo['rangepage'])) - 1) * $pageinfo['rangepage']) - $pageinfo['rangepage'] + 1;

        $min = $back ? ($back + $pageinfo['rangepage']) : 1;

        $next = $pageinfo['currentpage'] + $pageinfo['rangepage'];
        while (($next > $pageinfo['rangepage']) && ($next % $pageinfo['rangepage'] != 1))
            $next--;
        if ($next > $total_pages)
            $next = 0;
        $max = $min + $pageinfo['rangepage'] - 1;
        $max = ($max >= $pageinfo['rangepage']) ? $max : $pageinfo['rangepage'];

        $max = ($max <= $total_pages) ? $max : $total_pages;

        //page back
        if ($back > 0) {
            $result['pageBack'] = "<span class=\"page\">{$otherInfo['laquo']}<a href=\"{$pageinfo['querystring']}&page={$back}\">{$otherInfo['back']}</a></span>";
        } else {
            $result['pageBack'] = '';
            $result['laquo'] = '';
        }

        //page list
        $result['pageList'] = '';
        for ($i = $min; $i < $max; $i++) {
            if ($i == $pageinfo['currentpage']) {
                $result['pageList'] .= "<span class=\"page_cur\">{$i}</span><span class=\"page\">{$otherInfo['pageSeparator']}</span>";
            } else {
                $result['pageList'] .= "<span class=\"page\"><a href=\"{$pageinfo['querystring']}&page={$i}\">{$i}</a>{$otherInfo['pageSeparator']}</span>";
            }
        }

        //if max
        if ($max == $pageinfo['currentpage']) {
            $result['pageList'] .= "<span class=\"page_cur\">{$max}</span><span>&nbsp;</span>";
        } else {
            $result['pageList'] .= "<span class=\"page\"><a href=\"{$pageinfo['querystring']}&page={$max}\" >{$max}</a><span>&nbsp;</span>";
        }

        //pageNext
        if ($next > 0) {
            $result['pageNext'] = "<span class=\"page\"><a href=\"{$pageinfo['querystring']}&page={$next}\">{$otherInfo['next']}</a>{$otherInfo['raquo']}</span>";
        } else {
            $result['pageNext'] = '';
            $result['raquo'] = '';
        }

        //pageDec
        $result['pageDec'] = '';
        if (($otherInfo['pageDec'] != '' && $pageinfo['currentpage'] > $min) || $otherInfo['alwayPageDec']) {
            $result['pageDec'] = "<span class=\"page\"><a href=\"{$pageinfo['querystring']}&page=" . ($pageinfo['currentpage'] - 1) . "\">{$otherInfo['pageDec']}</a>";
        }

        //pageInc
        $result['pageInc'] = '';
        if (($otherInfo['pageInc'] != '' && $pageinfo['currentpage'] < $max) || $otherInfo['alwayPageInc']) {
            $result['pageInc'] = "<span class=\"page\"><a href=\"{$pageinfo['querystring']}&page=" . ($pageinfo['currentpage'] + 1) . "\">{$otherInfo['pageInc']}</a>";
        }

        //template
        $template = $otherInfo['template'];
        foreach ($result as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }

//end function
//for rewriteurl
    public function createPageNumberListRewriteURL($total_records, &$pageinfo, $pageName = 'Page: ', &$otherInfo = NULL) {
        $paging = PAGING::createPageNumberList($total_records, $pageinfo, $pageName, $otherInfo);

        for ($page = 1; $page <= $pageinfo['total_pages']; $page++) {
            $paging = str_replace("&page={$page}", "/page/{$page}", $paging);
        }

        return $paging;
    }

//for AJAX
    function createPagesNumberListAJAX($total_records, &$pageinfo, &$otherInfo = NULL) {
        if (!$total_records)
            return '';

        //other info
        if (!isset($otherInfo['laquo'])) {
            $otherInfo['laquo'] = '&laquo';
        }
        if (!isset($otherInfo['raquo'])) {
            $otherInfo['raquo'] = '&raquo';
        }
        if (!isset($otherInfo['back'])) {
            $otherInfo['back'] = 'back';
        }
        if (!isset($otherInfo['next'])) {
            $otherInfo['next'] = 'next';
        }
        if (!isset($otherInfo['pageDec'])) {
            $otherInfo['pageDec'] = '';
        }
        if (!isset($otherInfo['alwayPageDec'])) {
            $otherInfo['alwayPageDec'] = FALSE;
        }
        if (!isset($otherInfo['pageInc'])) {
            $otherInfo['pageInc'] = '';
        }
        if (!isset($otherInfo['alwayPageInc'])) {
            $otherInfo['alwayPageInc'] = FALSE;
        }
        if (!isset($otherInfo['pageSeparator'])) {
            $otherInfo['pageSeparator'] = '&nbsp;|&nbsp;';
        }
        if (!isset($otherInfo['template'])) {
            $otherInfo['template'] = 'Page: {laquo} {pageBack} {pageDec} {pageList} {pageInc} {pageNext} {raquo}';
        }

        //result
        $result['laquo'] = $otherInfo['laquo'];
        $result['raquo'] = $otherInfo['raquo'];

        $total_pages = ceil($total_records / $pageinfo['rowperpage']);
        if ($total_pages <= 1 && !$pageinfo['alwaypaging']) {
            return '';
        }

        $pageinfo['total_pages'] = $total_pages;

        if ($pageinfo['currentpage'] > $total_pages)
            $pageinfo['currentpage'] = $total_pages;
        if ($pageinfo['currentpage'] < 1)
            $pageinfo['currentpage'] = 1;

        $back = intval((((ceil($pageinfo['currentpage'] / $pageinfo['rangepage'])) - 1) * $pageinfo['rangepage']) - $pageinfo['rangepage'] + 1);

        $min = $back ? ($back + $pageinfo['rangepage']) : 1;

        $next = $pageinfo['currentpage'] + $pageinfo['rangepage'];
        while (($next > $pageinfo['rangepage']) && ($next % $pageinfo['rangepage'] != 1))
            $next--;
        if ($next > $total_pages) {
            $next = 0;
        }

        $max = $min + $pageinfo['rangepage'] - 1;
        $max = ($max >= $pageinfo['rangepage']) ? $max : $pageinfo['rangepage'];
        $max = ($max <= $total_pages) ? $max : $total_pages;

        //page back
        if ($back > 0) {
            $url = str_replace('{pageNumber}', $back, $pageinfo['querystring']);
            $result['pageBack'] = "{$otherInfo['laquo']}<a href=\"{$url}\">{$otherInfo['back']}</a>";
        } else {
            $result['pageBack'] = '';
            $result['laquo'] = '';
        }

        //page list
        $result['pageList'] = '';
        for ($i = $min; $i < $max; $i++) {
            if ($i == $pageinfo['currentpage']) {
                $result['pageList'] .= "{$i}{$otherInfo['pageSeparator']}";
            } else {
                $url = str_replace('{pageNumber}', $i, $pageinfo['querystring']);
                $result['pageList'] .= "<a href=\"{$url}\">{$i}</a>{$otherInfo['pageSeparator']}";
            }
        }

        //max
        if ($max == $pageinfo['currentpage']) {
            $result['pageList'] .= "{$max}";
        } else {
            $url = str_replace('{pageNumber}', $max, $pageinfo['querystring']);
            $result['pageList'] .= "<a href=\"{$url}\">{$max}</a>";
        }

        //pageNext
        if ($next > 0) {
            $url = str_replace('{pageNumber}', $next, $pageinfo['querystring']);
            $result['pageNext'] = "<a href=\"{$url}\">{$otherInfo['next']}</a>{$otherInfo['raquo']}";
        } else {
            $result['pageNext'] = '';
            $result['raquo'] = '';
        }

        //pageDec
        $result['pageDec'] = '';
        if (($otherInfo['pageDec'] != '' && $pageinfo['currentpage'] > $min) || $otherInfo['alwayPageDec']) {
            $url = str_replace('{pageNumber}', ($pageinfo['currentpage'] - 1), $pageinfo['querystring']);
            $result['pageDec'] = "<a href=\"{$url}\">{$otherInfo['pageDec']}</a>";
        }
        if ($otherInfo['pageDec'] != '' && $pageinfo['currentpage'] == $min && $otherInfo['alwayPageDec']) {
            $result['pageDec'] = $otherInfo['pageDec'];
        }

        //pageInc
        $result['pageInc'] = '';
        if (($otherInfo['pageInc'] != '' && $pageinfo['currentpage'] < $max) || $otherInfo['alwayPageInc']) {
            $url = str_replace('{pageNumber}', ($pageinfo['currentpage'] + 1), $pageinfo['querystring']);
            $result['pageInc'] = "<a href=\"{$url}\">{$otherInfo['pageInc']}</a>";
        }
        if ($otherInfo['pageInc'] != '' && $pageinfo['currentpage'] == $max && $otherInfo['alwayPageInc']) {
            $result['pageInc'] = $otherInfo['pageInc'];
        }

        //template
        $template = $otherInfo['template'];
        foreach ($result as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }

        return $template;
    }

//end function
//////////////////////
#tu dong kiem tra trang hien tai dang dung`, can cu vao request "&$pagekey="
    public static function getCurrentPage($pagekey = 'page') {
        if ($pagekey == '') {
            $key = 'page';
        } else {
            $key = $pagekey;
        }

        $page = intval(IO::getKey($key, 1));
        if ($page < 1) {
            $page = 1;
        }
        view($page);
        return $page;
    }

    public static function getCurrentPageRewriteURL() {
        $s = __REWRITEURL::GetQueryString();
        if ($s == '') {
            return 1;
        }

        $s = explode('/page/', strtolower($s));
        if (!is_array($s) || count($s) != 2) {
            return 1;
        }

        $page = abs(intval($s[1]));

        if (!$page) {
            $page = 1;
        }

        return intval($page);
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
    public static function getLimit($currentpage = 1, $rowperpage = 10, $typereturn = 'text') {
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

}

//end class
?>