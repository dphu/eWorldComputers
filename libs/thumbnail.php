<?php

if (!defined('IN_SYSTEM'))
    die(header('Location: ../die.php'));
?>
<?php

class Thumbnail {

    var $sourceDir;
    var $targetDir;
    var $namePrefix;
    var $maxWidth;
    var $maxHeight;
    var $errors;

    /**
     * Constructor of ImageUtilities class
     * This method is used to establish default parameters
     */
    function Thumbnail($sourceDir = null, $targetDir = null, $namePrefix = null) {
        if (!is_null($sourceDir))
            $this->setSourceDir($sourceDir);
        if (!is_null($targetDir))
            $this->setTargetDir($targetDir);
        if (!is_null($namePrefix))
            $this->setNamePrefix($namePrefix);
    }

    /**
     * Source Directory
     */
    function setSourceDir($dir) {
        if (!is_dir($dir) || !is_readable($dir)) {
            die("The \"" . $dir . "\" directory is not exists or content is not readable");
        }

        $this->sourceDir = $dir;
    }

    function getSourceDir() {
        return $this->sourceDir;
    }

    /**
     * Target Directory
     */
    function setTargetDir($dir) {
        if (!is_dir($dir) || !is_writable($dir)) {
            die("The \"{$dir}\" directory is not exists or content is not writable");
        }

        $this->targetDir = $dir;
    }

    function getTargetDir() {
        return $this->targetDir;
    }

    /* Name prefix */

    function setNamePrefix($prefix) {
        $this->namePrefix = strtolower(trim($prefix));
    }

    /* Set max size of thumbnail */

    function setMaxSize($width, $height) {
        $this->maxWidth = $width;
        $this->maxHeight = $height;
    }

    function make($imageName) {
        $sourceImage = $this->getSourceDir() . DIRECTORY_SEPARATOR . $imageName;
        $targetImage = $this->getTargetDir() . DIRECTORY_SEPARATOR . $this->namePrefix . $imageName;

        if (file_exists($targetImage) && !is_dir($targetImage)) {
            return true;
        }

        if (!file_exists($sourceImage) || !is_file($sourceImage)) {
            $this->errors = "Image source is not exists";
            return false;
        }

        $nameReversed = strrev($imageName);
        $imageEx = strtolower(strrev(substr($nameReversed, 0, strpos($nameReversed, '.'))));

        if (!in_array($imageEx, array('jpg', 'png', 'gif'))) {
            $this->errors = "File type is not supported";
            return false;
        }

        list($srcWidth, $srcHeight) = getImageSize($sourceImage);

        if ($srcWidth <= $this->maxWidth && $srcHeight <= $this->maxHeight) {
            copy($sourceImage, $targetImage);
        } else {
            $dstWidth = $dstHeight = 0;
            if (($srcWidth >= $srcHeight) || ($srcWidth - $this->maxWidth > $srcHeight - $this->maxHeight)) {
                $dstWidth = $this->maxWidth;
                $dstHeight = ($dstWidth / $srcWidth) * $srcHeight;
            } else {
                $dstHeight = $this->maxHeight;
                $dstWidth = ($dstHeight / $srcHeight) * $srcWidth;
            }

            switch ($imageEx) {
                case 'gif': $imageCreateFrom = 'imageCreateFromGif';
                    break;
                case 'png': $imageCreateFrom = 'imageCreateFromPng';
                    break;
                case 'jpg': $imageCreateFrom = 'imageCreateFromJpeg';
                    break;
            }

            $resource = $imageCreateFrom($sourceImage);
            $target = imageCreateTrueColor($dstWidth, $dstHeight);

            if (!imageCopyResampled($target, $resource, 0, 0, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight)) {
                $this->errors = "Image is not resized";
                return false;
            }

            switch ($imageEx) {
                case 'gif': imageGif($target, $targetImage);
                    break;
                case 'png': imagePng($target, $targetImage);
                    break;
                case 'jpg': imageJpeg($target, $targetImage, 100);
                    break;
            }
        }

        return true;
    }

}

/*
  $maxWidth = (isset($_GET['width']) && is_numeric($_GET['width'])) ? intval($_GET['width']) : 80;
  $maxHeight = (isset($_GET['height']) && is_numeric($_GET['height'])) ? intval($_GET['height']) : 80;
  $imageName = (isset($_GET['image'])) ? strtolower(trim($_GET['image'])) : false;

  $sourceDir = "upload" . DIRECTORY_SEPARATOR;
  $targetDir = "thumbnail" . DIRECTORY_SEPARATOR;
  $namePrefix = "thumb_{$maxWidth}_{$maxHeight}_";

  if(file_exists($sourceDir . $imageName) && $imageName !== false){
  $image = new ImageUtilities();
  $image->setSourceDir($sourceDir);
  $image->setTargetDir($targetDir);
  $image->setMaxSize(new Dimension($maxWidth, $maxHeight));
  $image->setNamePrefix($namePrefix);

  try {
  $image->getThumbnail($imageName);
  $fhandle = fopen($targetDir . $namePrefix . $imageName, 'rb');
  if($fhandle){
  header('Content-type: application/octet-stream');
  header('Content-length: ' . filesize($targetDir . $namePrefix . $imageName));
  fpassthru($fhandle);
  fclose($fhandle);
  }
  } catch (ImageUtilitiesException $ie){
  echo $ie->getMessage();
  }
  }
 */
?>