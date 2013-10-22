<?php

if (!defined('IN_SYSTEM'))
    die(header('Location: ../die.php'));
?>
<?php

//-- resize image
define('CONVERT_IS_GD2', 1);
define('CONVERT_IMAGE_TOOL', "gd");
define('CONVERT_IMAGE_QUALITY', "90");

//----------------------------------------------------------
// get file format type -----------------------------------
function getFileType($filename) {
    $ext = getFileExtension($filename);
    $ext = strtolower($ext);
    switch ($ext) {
        case 'jpg':
        case 'gif':
        case 'png':
        case 'bmp':
        case 'jpeg':            // Alternate JPEG
        case 'jpe':             // Alternate JPEG
            return 'image';
            break;
        case 'avi':             // Microsoft AVI
        case 'wmv':
        case 'mpg':
        case 'mpeg': // MPEG video
            return 'video';
            break;
        case 'mp3':             // MPEG-3 audio
        case 'wav':             // Microsoft WAV audio
        case 'wma':              // Realaudio
        case 'asf':             // Realaudio
            return 'audio';
            break;
        case 'swf':             // Realaudio
            return 'flash';
            break;
        case 'zip':             // MPEG-3 audio
        case 'rar':             // Microsoft WAV audio
            return 'compress';
            break;
        default:
            return false;       // No valid match - failure.
            break;
    }
}

// ------------------------------------------
// get Name Upload File ----------------------
function getNameUploadFile($pPath, $pFileName) {
    $pFileName = str_replace(" ", "", $pFileName);
    $pFileName = strtolower($pFileName);
    $pFileName1 = $pFileName;
    if ((!file_exists("$pPath/$pFileName")) && (checkNameFileThumnail($pPath, $pFileName)))
        return $pFileName;
    else {
        $k = 0;
        while (1) {
            $k++;
            $pFileName1 = plusFilename($pFileName1, "$k");
            if ((!file_exists("$pPath/$pFileName1")) && (checkNameFileThumnail($pPath, $pFileName)))
                return $pFileName1;
        }
    }
}

// -----------------------------------------------
function checkNameFileThumnail($pPath, $pFileName) {
    global $ARRTHUMNAIL;
    $ret = true;
    for ($i = 0; $i < sizeof($ARRTHUMNAIL); $i++) {
        if (file_exists(PlusFile("$pPath/$pFileName", "_" . $ARRTHUMNAIL[$i]))) {
            $ret = false;
            break;
        }
    }
    return $ret;
}

function getFileExtension($pathfilename) {
    return ereg_replace('^.*\.', '', $pathfilename);
}

function removeExtensionFile($str) {
    $i = strrpos($str, ".");
    if (!$i)
        return "";
    $name = substr($str, 0, $i);
    return $name;
}

function plusFilename($str, $plus) {
    $name = removeExtensionFile($str);
    $exten = getFileExtension($str);
    return $name . $plus . "." . $exten;
}

function resize_image($src, $dest, $target) {
    $image_info = getimagesize($src);
    list($s, $w, $r, $h, $b) = split('"', $image_info[3], 5);
    $width = $target;
    $height = ($target * $h) / $w;

    $i = @resize_image_gd($src, $dest, CONVERT_IMAGE_QUALITY, $width, $height, $image_info);

    if ($i)
        return 1;
    else {
        return 0;
    }
}

function resize_image_height($src, $dest, $target) {
    $image_info = @getimagesize($src);
    @list($s, $w, $r, $h, $b) = @split('"', $image_info[3], 5);
    $width = ($target * $w) / $h;
    $height = $target;
    resize_image_gd($src, $dest, CONVERT_IMAGE_QUALITY, $width, $height, $image_info);
}

function resize_image_gd($src, $dest, $quality, $width, $height, $image_info) {
    //if($image_info[2]==1) die("Don't support for GIF file!");
    if ($image_info[2] > 3) {
        @copy($src, $dest);
        return 0;
    }
    $types = array(1 => "gif", 2 => "jpeg", 3 => "png");
    if (defined('CONVERT_IS_GD2') && CONVERT_IS_GD2 == 1) {
        $thumb = @imagecreatetruecolor($width, $height);
    } else {
        $thumb = @imagecreate($width, $height);
    }
    $image_create_handle = "imagecreatefrom" . $types[$image_info[2]];
    if ($image = $image_create_handle($src)) {
        if (@defined('CONVERT_IS_GD2') && CONVERT_IS_GD2 == 1) {
            @imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
        } else {
            @imagecopyresized($thumb, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
        }
        //$image_handle = "image".$types[$image_info[2]];
        //$image_handle($thumb, $dest, $quality);
        @imagejpeg($thumb, $dest, $quality);
        @imagedestroy($image);
        @imagedestroy($thumb);
    }
    return (file_exists($dest)) ? 1 : 0;
}

function crop_image($image_filename, $thumb_location, $image_thumb_size) {
//@$image_filename - the filename of the image you want
//to get a thumbnail for (relative to location of this
//function).
//@$thumb_location - the url (relative to location of this
//function) to save the thumbnail.
//@$image_thumb_size - the x-y dimension of your thumb
//in pixels.
    list($ow, $oh) = getimagesize($image_filename);
    $image_original = imagecreatefromjpeg($image_filename);
    $image_thumb = imagecreatetruecolor($image_thumb_size, $image_thumb_size);
    if ($ow > $oh) {
        $off_w = ($ow - $oh) / 2;
        $off_h = 0;
        $ow = $oh;
    } elseif ($oh > $ow) {
        $off_w = 0;
        $off_h = ($oh - $ow) / 2;
        $oh = $ow;
    } else {
        $off_w = 0;
        $off_h = 0;
    }
    imagecopyresampled($image_thumb, $image_original, 0, 0, $off_w, $off_h, $ow, $oh, $ow, $oh);
    imagejpeg($image_thumb, $thumb_location, CONVERT_IMAGE_QUALITY);
}

//end function

function crop_image_ex($image_filename, $thumb_location, $image_size_width, $image_size_height) {
//@$image_filename - the filename of the image you want
//to get a thumbnail for (relative to location of this
//function).
//@$thumb_location - the url (relative to location of this
//function) to save the thumbnail.
//@$image_size_??? - the x-y dimension of your thumb
//in pixels.
    list($ow, $oh) = getimagesize($image_filename);
    $image_original = imagecreatefromjpeg($image_filename);
    $image_thumb = imagecreatetruecolor($image_size_width, $image_size_height);
    if ($ow > $oh) {
        $off_w = ($ow - $oh) / 2;
        $off_h = 0;
        $ow = $oh;
    } elseif ($oh > $ow) {
        $off_w = 0;
        $off_h = ($oh - $ow) / 2;
        $oh = $ow;
    } else {
        $off_w = 0;
        $off_h = 0;
    }
    imagecopyresampled($image_thumb, $image_original, 0, 0, $off_w, $off_h, $ow, $oh, $ow, $oh);
    imagejpeg($image_thumb, $thumb_location, CONVERT_IMAGE_QUALITY);
}

//end function 

function rotateImage($src, $dst, $count = 1) {
    if (!file_exists($src)) {
        return false;
    }

    switch ($count) {
        case 0:
            $degrees = 0;
            break;
        case 1:
            $degrees = 90;
            break;
        case 2:
            $degrees = 180;
            break;
        case 3:
            $degrees = 270;
            break;
    }

// Load
    $source = imagecreatefromjpeg($src);
// Rotate
    $rotate = imagerotate($source, 360 - $degrees, 0);
// Output
    imagejpeg($rotate, $dst, CONVERT_IMAGE_QUALITY);

    imagedestroy($rotate);
    imagedestroy($source);

    return true;
}

function makeOption($value, $text = '', $value_name = 'value', $text_name = 'text') {
    $obj = new stdClass;
    $obj->$value_name = $value;
    $obj->$text_name = trim($text) ? $text : $value;
    return $obj;
}

/* function makeOption( $value, $text, $valueName='value', $textName='text' ) {
  return array(
  $valueName => $value,
  $textName => $text
  );
  } */

function ampReplace($text) {
    $text = str_replace('&&', '*--*', $text);
    $text = str_replace('&#', '*-*', $text);
    $text = str_replace('&amp;', '&', $text);
    $text = preg_replace('|&(?![\w]+;)|', '&amp;', $text);
    $text = str_replace('*-*', '&#', $text);
    $text = str_replace('*--*', '&&', $text);

    return $text;
}

function selectList(&$arr, $tag_name, $tag_attribs, $key, $text, $selected = NULL) {
    // check if array
    if (is_array($arr)) {
        reset($arr);
    }

    $html = "\n<select name=\"$tag_name\" $tag_attribs>";
    $count = count($arr);

    for ($i = 0, $n = $count; $i < $n; $i++) {
        $k = $arr[$i]->$key;
        $t = $arr[$i]->$text;
        $id = ( isset($arr[$i]->id) ? @$arr[$i]->id : null);

        $extra = '';
        $extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
        if (is_array($selected)) {
            foreach ($selected as $obj) {
                $k2 = $obj->$key;
                if ($k == $k2) {
                    $extra .= " selected=\"selected\"";
                    break;
                }
            }
        } else {
            $extra .= ($k == $selected ? " selected=\"selected\"" : '');
        }
        $html .= "\n\t<option value=\"" . $k . "\"$extra>" . $t . "</option>";
    }
    $html .= "\n</select>\n";

    return $html;
}

function mosPathName($p_path, $p_addtrailingslash = true) {
    $retval = "";

    $isWin = (substr(PHP_OS, 0, 3) == 'WIN');

    if ($isWin) {
        $retval = str_replace('/', '\\', $p_path);
        if ($p_addtrailingslash) {
            if (substr($retval, -1) != '\\') {
                $retval .= '\\';
            }
        }

        // Check if UNC path
        $unc = substr($retval, 0, 2) == '\\\\' ? 1 : 0;

        // Remove double \\
        $retval = str_replace('\\\\', '\\', $retval);

        // If UNC path, we have to add one \ in front or everything breaks!
        if ($unc == 1) {
            $retval = '\\' . $retval;
        }
    } else {
        $retval = str_replace('\\', '/', $p_path);
        if ($p_addtrailingslash) {
            if (substr($retval, -1) != '/') {
                $retval .= '/';
            }
        }

        // Check if UNC path
        $unc = substr($retval, 0, 2) == '//' ? 1 : 0;

        // Remove double //
        $retval = str_replace('//', '/', $retval);

        // If UNC path, we have to add one / in front or everything breaks!
        if ($unc == 1) {
            $retval = '/' . $retval;
        }
    }

    return $retval;
}

function mosReadDirectory($path, $filter = '.', $recurse = false, $fullpath = false) {
    $arr = array();
    if (!@is_dir($path)) {
        return $arr;
    }
    $handle = opendir($path);

    while ($file = readdir($handle)) {
        $dir = mosPathName($path . '/' . $file, false);
        $isDir = is_dir($dir);
        if (($file != ".") && ($file != "..")) {
            if (preg_match("/$filter/", $file)) {
                if ($fullpath) {
                    $arr[] = trim(mosPathName($path . '/' . $file, false));
                } else {
                    $arr[] = trim($file);
                }
            }
            if ($recurse && $isDir) {
                $arr2 = mosReadDirectory($dir, $filter, $recurse, $fullpath);
                $arr = array_merge($arr, $arr2);
            }
        }
    }
    closedir($handle);
    asort($arr);
    return $arr;
}

function ReadImages($imagePath, $folderPath, &$folders, &$images) {
    $imgFiles = mosReadDirectory($imagePath);

    foreach ($imgFiles as $file) {
        $ff_ = $folderPath . $file . '/';
        $ff = $folderPath . $file;
        $i_f = $imagePath . '/' . $file;

        if (is_dir($i_f) && $file != 'CVS' && $file != '.svn') {
            $folders[] = makeOption($ff_);
            ReadImages($i_f, $ff_, $folders, $images);
        } else if (eregi("bmp|gif|jpg|png", $file) && is_file($i_f)) {
            // leading / we don't need
            $imageFile = substr($ff, 1);
            $images[$folderPath][] = makeOption($imageFile, $file);
        }
    }
}

function GetImages(&$images, $path, $base = '/') {
    if (is_array($base) && count($base) > 0) {
        if ($base[0]->value != '/') {
            $base = $base[0]->value . '/';
        } else {
            $base = $base[0]->value;
        }
    } else {
        $base = '/';
    }

    if (!isset($images[$base])) {
        $images[$base][] = makeOption('');
    }

    $javascript = "onchange=\"previewImage( 'imagefiles', 'view_imagefiles', '$path/' )\" onfocus=\"previewImage( 'imagefiles', 'view_imagefiles', '$path/' )\"";
    $getimages = selectList($images[$base], 'imagefiles', 'class="inputbox" size="10" multiple="multiple" ' . $javascript, 'value', 'text', null);

    return $getimages;
}

?>
