<?php

class Upload {

    var $maxSize = 0;
    var $maxWidth = 0;
    var $maxHeight = 0;
    var $allowedTypes = "";
    var $fileTemp = "";
    var $fileName = "";
    var $origName = "";
    var $fileType = "";
    var $fileSize = "";
    var $fileExt = "";
    var $uploadPath = "";
    var $overwrite = FALSE;
    var $encryptName = FALSE;
    var $isImage = FALSE;
    var $imageWidth = '';
    var $imageHeight = '';
    var $imageType = '';
    var $imageSizeStr = '';
    var $errorMsg = array();
    var $removeSpaces = TRUE;
    var $tempPrefix = "temp_file_";
    var $mimes = array(
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'csv' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel'),
        'bin' => 'application/macbinary',
        'dms' => 'application/octet-stream',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'exe' => 'application/octet-stream',
        'class' => 'application/octet-stream',
        'psd' => 'application/x-photoshop',
        'so' => 'application/octet-stream',
        'sea' => 'application/octet-stream',
        'dll' => 'application/octet-stream',
        'oda' => 'application/oda',
        'pdf' => array('application/pdf', 'application/x-download'),
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'mif' => 'application/vnd.mif',
        'xls' => array('application/excel', 'application/vnd.ms-excel'),
        'ppt' => 'application/powerpoint',
        'wbxml' => 'application/wbxml',
        'wmlc' => 'application/wmlc',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'gtar' => 'application/x-gtar',
        'gz' => 'application/x-gzip',
        'php' => 'application/x-httpd-php',
        'php4' => 'application/x-httpd-php',
        'php3' => 'application/x-httpd-php',
        'phtml' => 'application/x-httpd-php',
        'phps' => 'application/x-httpd-php-source',
        'js' => 'application/x-javascript',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'tar' => 'application/x-tar',
        'tgz' => 'application/x-tar',
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'ram' => 'audio/x-pn-realaudio',
        'rm' => 'audio/x-pn-realaudio',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'ra' => 'audio/x-realaudio',
        'rv' => 'video/vnd.rn-realvideo',
        'wav' => 'audio/x-wav',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'jpeg' => array('image/jpeg', 'image/pjpeg'),
        'jpg' => array('image/jpeg', 'image/pjpeg'),
        'jpe' => array('image/jpeg', 'image/pjpeg'),
        'png' => array('image/png', 'image/x-png'),
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'css' => 'text/css',
        'html' => 'text/html',
        'htm' => 'text/html',
        'shtml' => 'text/html',
        'txt' => 'text/plain',
        'text' => 'text/plain',
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'xml' => 'text/xml',
        'xsl' => 'text/xml',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'doc' => 'application/msword',
        'xl' => 'application/excel',
        'eml' => 'message/rfc822',
        //tai lieu
        'zip' => '',
        'rar' => '',
        'doc' => '',
        'docx' => '',
        'ppt' => '',
        'pptx' => '',
        'xls' => '',
        'xlsx' => '',
    );

    /**
     * Constructor
     *
     * @access	public
     */
    function Upload($props = array()) {
        if (count($props) > 0) {
            $this->initialize($props);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Initialize preferences
     *
     * @access	public
     * @param	array
     * @return	void
     */
    function initialize($config = array()) {
        $defaults = array(
            'maxSize' => 0,
            'maxWidth' => 0,
            'maxHeight' => 0,
            'allowedTypes' => "",
            'fileTemp' => "",
            'fileName' => "",
            'origName' => "",
            'fileType' => "",
            'fileSize' => "",
            'fileExt' => "",
            'uploadPath' => "",
            'overwrite' => FALSE,
            'encryptName' => FALSE,
            'isImage' => FALSE,
            'imageWidth' => '',
            'imageHeight' => '',
            'imageType' => '',
            'imageSizeStr' => '',
            'errorMsg' => array(),
            'removeSpaces' => TRUE,
            'tempPrefix' => "temp_file_"
        );


        foreach ($defaults as $key => $val) {
            if (isset($config[$key])) {
                $method = 'set_' . $key;

                if (method_exists($this, $method)) {
                    $this->$method($config[$key]);
                } else {
                    $this->$key = $config[$key];
                }
            } else {
                $this->$key = $val;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Perform the file upload
     *
     * @access	public
     * @return	bool
     */
    function doUpload($field = 'userfile') {
        // Is $_FILES[$field] set? If not, no reason to continue.
        if (!isset($_FILES[$field])) {
            $this->setError('Upload Control Not Set');
            return FALSE;
        }

        // Is the upload path valid?
        if (!$this->validateUploadPath()) {
            return FALSE;
        }

        // Was the file able to be uploaded? If not, determine the reason why.
        if (!is_uploaded_file($_FILES[$field]['tmp_name'])) {
            $error = (!isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];

            switch ($error) {
                case 1 : $this->setError('File exceeds limit');
                    break;
                case 3 : $this->setError('File partial');
                    break;
                case 4 : $this->setError('No file selected');
                    break;
                default : $this->setError('No file selected');
                    break;
            }

            return FALSE;
        }

        // Set the uploaded data as class variables
        $this->fileTemp = $_FILES[$field]['tmp_name'];
        $this->fileName = $_FILES[$field]['name'];
        $this->fileSize = $_FILES[$field]['size'];
        $this->fileType = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type']);
        $this->fileType = strtolower($this->fileType);
        $this->fileExt = $this->getExtension($_FILES[$field]['name']);

        // Convert the file size to kilobytes
        if ($this->fileSize > 0) {
            $this->fileSize = round($this->fileSize / 1024, 2);
        }

        // Is the file type allowed to be uploaded?
        if (!$this->isAllowedFiletype()) {
            $this->setError('Invalid file type');
            return FALSE;
        }

        // Is the file size within the allowed maximum?
        if (!$this->isAllowedFilesize()) {
            $this->setError('Invalid file size');
            return FALSE;
        }

        // Are the image dimensions within the allowed size?
        // Note: This can fail if the server has an open_basdir restriction.
        if (!$this->isAllowedDimensions()) {
            $this->setError('Invalid dimensions');
            return FALSE;
        }

        // Sanitize the file name for security
        $this->fileName = $this->cleanFileName($this->fileName);

        // Remove white spaces in the name
        if ($this->removeSpaces == TRUE) {
            $this->fileName = preg_replace("/\s+/", "_", $this->fileName);
        }

        /*
         * Validate the file name
         * This function appends an number onto the end of
         * the file if one with the same name already exists.
         * If it returns false there was a problem.
         */
        $this->origName = $this->fileName;

        if ($this->overwrite == FALSE) {
            $this->fileName = $this->setFilename($this->uploadPath, $this->fileName);

            if ($this->fileName === FALSE) {
                return FALSE;
            }
        }

        /*
         * Move the file to the final destination
         * To deal with different server configurations
         * we'll attempt to use copy() first.  If that fails
         * we'll use move_uploaded_file().  One of the two should
         * reliably work in most environments
         */
        if (!@copy($this->fileTemp, $this->uploadPath . $this->fileName)) {
            if (!@move_uploaded_file($this->fileTemp, $this->uploadPath . $this->fileName)) {
                $this->setError('Destination error');
                return FALSE;
            }
        }

        /*
         * Set the finalized image dimensions
         * This sets the image width/height (assuming the
         * file was an image).  We use this information
         * in the "data" function.
         */
        $this->setImageProperties($this->uploadPath . $this->fileName);

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Finalized Data Array
     * 	
     * Returns an associative array containing all of the information
     * related to the upload, allowing the developer easy access in one array.
     *
     * @access	public
     * @return	array
     */
    function data() {
        return array(
            'fileName' => $this->fileName,
            'fileType' => $this->fileType,
            'filePath' => $this->uploadPath,
            'full_path' => $this->uploadPath . $this->fileName,
            'raw_name' => str_replace($this->fileExt, '', $this->fileName),
            'origName' => $this->origName,
            'fileExt' => $this->fileExt,
            'fileSize' => $this->fileSize,
            'isImage' => $this->isImage(),
            'imageWidth' => $this->imageWidth,
            'imageHeight' => $this->imageHeight,
            'imageType' => $this->imageType,
            'imageSizeStr' => $this->imageSizeStr,
        );
    }

    // --------------------------------------------------------------------

    /**
     * Set Upload Path
     *
     * @access	public
     * @param	string
     * @return	void
     */
    function setUploadPath($path) {
        $this->uploadPath = $path;
    }

    // --------------------------------------------------------------------

    /**
     * Set the file name
     *
     * This function takes a filename/path as input and looks for the
     * existence of a file with the same name. If found, it will append a
     * number to the end of the filename to avoid overwriting a pre-existing file.
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	string
     */
    function setFilename($path, $filename) {
        if ($this->encryptName == TRUE) {
            mt_srand();
            $filename = md5(uniqid(mt_rand())) . $this->fileExt;
        }

        if (!file_exists($path . $filename)) {
            return $filename;
        }

        $filename = str_replace($this->fileExt, '', $filename);

        $new_filename = '';
        for ($i = 1; $i < 100; $i++) {
            if (!file_exists($path . $filename . $i . $this->fileExt)) {
                $new_filename = $filename . $i . $this->fileExt;
                break;
            }
        }

        if ($new_filename == '') {
            $this->setError('Bad filename');
            return FALSE;
        } else {
            return $new_filename;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Set Maximum File Size
     *
     * @access	public
     * @param	integer
     * @return	void
     */
    function setMaxFileSize($n) {
        $this->maxSize = (!eregi("^[[:digit:]]+$", $n)) ? 0 : $n;
    }

    // --------------------------------------------------------------------

    /**
     * Set Maximum Image Width
     *
     * @access	public
     * @param	integer
     * @return	void
     */
    function setMaxWidth($n) {
        $this->maxWidth = (!eregi("^[[:digit:]]+$", $n)) ? 0 : $n;
    }

    // --------------------------------------------------------------------

    /**
     * Set Maximum Image Height
     *
     * @access	public
     * @param	integer
     * @return	void
     */
    function setMaxHeight($n) {
        $this->maxHeight = (!eregi("^[[:digit:]]+$", $n)) ? 0 : $n;
    }

    // --------------------------------------------------------------------

    /**
     * Set Allowed File Types
     *
     * @access	public
     * @param	string
     * @return	void
     */
    function setAllowedTypes($types) {
        $this->allowedTypes = explode('|', $types);
    }

    // --------------------------------------------------------------------

    /**
     * Set Image Properties
     *
     * Uses GD to determine the width/height/type of image
     *
     * @access	public
     * @param	string
     * @return	void
     */
    function setImageProperties($path = '') {
        if (!$this->isImage()) {
            return;
        }

        if (function_exists('getimagesize')) {
            if (FALSE !== ($D = @getimagesize($path))) {
                $types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

                $this->imageWidth = $D['0'];
                $this->imageHeight = $D['1'];
                $this->imageType = (!isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
                $this->imageSizeStr = $D['3'];  // string containing height and width
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Validate the image
     *
     * @access	public
     * @return	bool
     */
    function isImage() {
        // IE will sometimes return odd mime-types during upload, so here we just standardize all
        // jpegs or pngs to the same file type.

        $png_mimes = array('image/x-png');
        $jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

        if (in_array($this->fileType, $png_mimes)) {
            $this->fileType = 'image/png';
        }

        if (in_array($this->fileType, $jpeg_mimes)) {
            $this->fileType = 'image/jpeg';
        }

        $img_mimes = array(
            'image/gif',
            'image/jpeg',
            'image/png',
        );

        return (in_array($this->fileType, $img_mimes, TRUE)) ? TRUE : FALSE;
    }

    // --------------------------------------------------------------------

    /**
     * Verify that the filetype is allowed
     *
     * @access	public
     * @return	bool
     */
    function isAllowedFiletype() {
        $fileEx = strtolower(substr($this->fileExt, 1));

        if (count($this->allowedTypes) == 0) {
            $this->setError('No file types');
            return false;
        }

        if (!in_array($fileEx, $this->allowedTypes)) {
            return false;
        }

        if (!isset($this->mimes[$fileEx])) {
            return false;
        }

        $fileMimes = $this->mimes[$fileEx];
        if (is_array($fileMimes) && in_array($this->fileType, $fileMimes)) {
            return true;
        }

        if ($fileMimes == $this->fileType) {
            return true;
        }

        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Verify that the file is within the allowed size
     *
     * @access	public
     * @return	bool
     */
    function isAllowedFilesize() {
        if ($this->maxSize != 0 AND $this->fileSize > $this->maxSize) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Verify that the image is within the allowed width/height
     *
     * @access	public
     * @return	bool
     */
    function isAllowedDimensions() {
        if (!$this->isImage()) {
            return TRUE;
        }

        if (function_exists('getimagesize')) {
            $D = @getimagesize($this->fileTemp);

            if ($this->maxWidth > 0 AND $D['0'] > $this->maxWidth) {
                return FALSE;
            }

            if ($this->maxHeight > 0 AND $D['1'] > $this->maxHeight) {
                return FALSE;
            }

            return TRUE;
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Validate Upload Path
     *
     * Verifies that it is a valid upload path with proper permissions.
     *
     *
     * @access	public
     * @return	bool
     */
    function validateUploadPath() {
        if ($this->uploadPath == '') {
            $this->setError('No file path');
            return FALSE;
        }

        if (function_exists('realpath') AND @realpath($this->uploadPath) !== FALSE) {
            $this->uploadPath = str_replace("\\", "/", realpath($this->uploadPath));
        }

        if (!@is_dir($this->uploadPath)) {
            $this->setError('No file path');
            return FALSE;
        }

        if (!is_writable($this->uploadPath)) {
            $this->setError('Folder not writable');
            return FALSE;
        }

        $this->uploadPath = preg_replace("/(.+?)\/*$/", "\\1/", $this->uploadPath);
        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Extract the file extension
     *
     * @access	public
     * @param	string
     * @return	string
     */
    function getExtension($filename) {
        $x = explode('.', $filename);
        return '.' . end($x);
    }

    // --------------------------------------------------------------------

    /**
     * Clean the file name for security
     *
     * @access	public
     * @param	string
     * @return	string
     */
    function cleanFileName($filename) {
        $bad = array(
            "<!--",
            "-->",
            "'",
            "<",
            ">",
            '"',
            '&',
            '$',
            '=',
            ';',
            '?',
            '/',
            "%20",
            "%22",
            "%3c", // <
            "%253c", // <
            "%3e", // >
            "%0e", // >
            "%28", // (
            "%29", // )
            "%2528", // (
            "%26", // &
            "%24", // $
            "%3f", // ?
            "%3b", // ;
            "%3d"  // =
        );

        foreach ($bad as $val) {
            $filename = str_replace($val, '', $filename);
        }

        return $filename;
    }

    // --------------------------------------------------------------------

    /**
     * Set an error message
     *
     * @access	public
     * @param	string
     * @return	void
     */
    function setError($msg) {
        if (is_array($msg)) {
            foreach ($msg as $val) {
                $this->errorMsg[] = $msg;
            }
        } else {
            $this->errorMsg[] = $msg;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Display the error message
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	string
     */
    function getErrors() {
        $str = '';
        foreach ($this->errorMsg as $val) {
            $str .= $val;
        }

        return $str;
    }

}

// END Upload Class
?>