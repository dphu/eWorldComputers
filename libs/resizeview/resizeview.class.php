<?php

if (!defined('IN_SYSTEM')) {
    $f = 'die.php';
    while (!file_exists($f) || !is_file($f))
        $f = '../' . $f;die(header('Location: ' . $f));
};

/**
 * @maingocmy2003@yahoo.com
 * @class tu dong resize view image theo kich thuoc cua 1 khung co san
 * */
class RESIZEVIEW {
    /*
      - nhan vao 1 image va 1 khung co kich thuoc cho san,
      - xuat ra web 1 image sao cho vua` nam trong khung da cho

     * @params: 
      - khung width
      - khung height
      - image file
      - max image width (option)
      - max image height (option)

     * @return: css style width, height (px) or NULL
     */

    public static function GET_RESIZE($box_W, $box_H, $image, $img_W = NULL, $img_H = NULL) {
        //not image
        if (!$size = @getimagesize($image)) {
            return NULL;
        }

        //error
        if (!is_array($size)) {
            return NULL;
        }

        //option?
        $img_W = (abs(intval($img_W)) && abs(intval($img_W)) <= $box_W) ? abs(intval($img_W)) : $box_W;
        $img_H = (abs(intval($img_H)) && abs(intval($img_H)) <= $box_H) ? abs(intval($img_H)) : $box_H;

        //NULL?
        if (!$img_W) {
            $img_W = $box_W;
        }
        if (!$img_H) {
            $img_H = $box_H;
        }

        //good?
        if ($size[0] <= $img_W && $size[1] <= $img_H) {
            return NULL;
        }

        //resize w?
        if ($size[0] > $img_W && $size[1] <= $img_H) {
            return "width:{$img_W}px;";
        }

        //resize h?
        if ($size[0] <= $img_W && $size[1] > $img_H) {
            return "height:{$img_H}px;";
        }

        //resize w & h?
        if ($size[0] > $img_W && $size[1] > $img_H) {
            return ($size[0] / $size[1] > $img_W / $img_H) ? "width:{$img_W}px;" : "height:{$img_H}px;";
        }

        //default
        return NULL;
    }

    //end function	

    private static function __getWidth(&$s, &$h) {
        return round(($h * $s[0]) / $s[1], 0);
    }

    private static function __getHeight(&$s, &$w) {
        return round(($w * $s[1]) / $s[0], 0);
    }

    public static function GET_RESIZE_FLASH_STYLE($box_W, $box_H, $flash) {
        //not image
        if (!$size = @getimagesize($flash)) {
            return " width=\"{$box_W}\" height=\"{$box_H}\" ";
        }

        //error
        if (!is_array($size)) {
            return " width=\"{$box_W}\" height=\"{$box_H}\" ";
        }

        //good?
        if ($size[0] <= $box_W && $size[1] <= $box_H) {
            return " width=\"{$size[0]}\" height=\"{$size[1]}\" ";
        }

        //resize w ? --> h:auto
        if ($size[0] > $box_W && $size[1] <= $box_H) {
            $w = $box_W;
            $h = RESIZEVIEW::__getHeight($size, $w);
            return " width=\"{$w}\" height=\"{$h}\" ";
        }

        //resize h ? --> w:auto
        if ($size[0] <= $box_W && $size[1] > $box_H) {
            $h = $box_H;
            $w = RESIZEVIEW::__getWidth($size, $h);
            return " width=\"{$w}\" height=\"{$h}\" ";
        }

        //resize w & h ?
        if ($size[0] > $box_W && $size[1] > $box_H) {
            if ($size[0] / $size[1] > $box_W / $box_H) { //w --> h:auto 
                $w = $box_W;
                $h = RESIZEVIEW::__getHeight($size, $w);
                return " width=\"{$w}\" height=\"{$h}\" ";
            } else { //h --> w:auto
                $h = $img_H;
                $w = round(($h * $img_W) / $img_H, 0);
                return " width=\"{$w}\" height=\"{$h}\" ";
            }
        }

        //default
        return "width=\"{$box_W}\" height=\"{$box_H}\" ";
    }

}

//end class
?>