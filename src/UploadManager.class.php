<?php
/*
*
* This class manage the ability to upload securily files
* NOTE: In case of Image, use checkPictures and uploadPictures to add security
*
*/

define('UPLOADMANAGER_FILE_SIZE',       'size');
define('UPLOADMANAGER_FILE_TYPE',       'type');
define('UPLOADMANAGER_FILE_TMP',        'tmp_name');
define('UPLOADMANAGER_FILE_NAME',       'name');
define('UPLOADMANAGER_FILE_ERROR',      'error');

define('UPLOADMANAGER_THUMB_WIDTH',     320);
define('UPLOADMANAGER_THUMB_HEIGHT',    240);

class UploadManager {
    private static $picturesMimes = array(
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/gif' => 'bmp',
        'image/webp' => 'webp',
    );
    
    public static function check(&$filename, $maxFileSize, &$mimesAllowedArray) {
        // Check is the file is available
        if (!isset($_FILE[$filename])) {
            return false;
        }

        $file = &$_FILE[$filename];

        // Check if an error occurs
        if ($file[UPLOADMANAGER_FILE_ERROR] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Extract real file data
        $size = filesize($file[UPLOADMANAGER_FILE_TMP]);

        if ($size === 0 || $size > $maxFileSize || $size > UPLOADMANAGER_MAX_FILE_SIZE) {
            return false;
        }

        // Test mime type
        if (!in_array($file[UPLOADMANAGER_FILE_TYPE], $mimesAllowedArray)) {
            return false;
        }

        return true;
    }

    public static function checkPictures(&$filename, $maxFileSize, &$indexMimesAllowedArray, $maxWidth, $maxHeight) {
        $mimesAllowedArray = array();
        foreach ($indexMimesAllowedArray as $indexMimesAllowed) {
            $mimesAllowedArray[] = self::$picturesMimes[$indexMimesAllowed];
        }
        if (!check($filename, $maxFileSize, $mimesAllowedArray)) {
            return false;
        }
        $imageSize = getimagesize($_FILES[$filename][UPLOADMANAGER_FILE_TMP]);
        if ($imageSize === false) {
            return false;
        }
        $width = $imageSize[0];
        $height = $imageSize[1];
        if (($maxWidth !== null && $width > $maxWidth) || ($maxHeight != null && $height > $maxHeight)) {
            return false;
        }
        return true;
    }

    public static function uploadFile(&$file, &$uploadingDirectory, &$filenameToAssign, &$extension) {
        $newAbsolutPath = $uploadingDirectory.'/'.$filenameToAssign.'.'.$extension;
        if (!move_uploaded_file($file[UPLOADMANAGER_FILE_TMP], $newAbsolutPath)) {
            return false;
        }
        unlink($file[UPLOADMANAGER_FILE_TMP]);
        return true;
    }

    public static function uploadPicture(&$file, $uploadingDirectory, $filenameToAssign, $extension) {
        $imageSize = getimagesize($file[UPLOADMANAGER_FILE_TMP]);
        if ($imageSize === false) {
            return false;
        }
        return self::uploadPicture($file, $uploadingDirectory, $filenameToAssign, $extension,
            $imageSize[0], $imageSize[1]);
    }

    public static function uploadPicture(&$file, $uploadingDirectory, $filenameToAssign, $extension, $newWidth, $newHeight) {
        $newAbsolutPath = $uploadingDirectory.'/'.$filenameToAssign.'.'.$extension;
        return self::uploadAndResizePicture($file[UPLOADMANAGER_FILE_TMP], $newAbsolutPath, $newWidth, $newHeight);
    }

    public static function uploadThumb(&$file, $uploadingDirectory, $filenameToAssign, $extension) {
        $newAbsolutPath = $uploadingDirectory.'/'.$filenameToAssign.'.'.$extension;
        return self::uploadAndResizePicture($file[UPLOADMANAGER_FILE_TMP], $newAbsolutPath,
            UPLOADMANAGER_THUMB_WIDTH, UPLOAD_MANAGER_THUMB_HEIGHT);;
    }

    private static function uploadAndResizePicture(&$pictureFileSrc, &$absolutPathDest, $newWidth, $newHeight) {
        $thumb = new Imagick($pictureFileSrc);
        if (!$thumb->resizeImage($newWidth, $newHeight, Imagick::FILTER_CATROM, 1)) {
            return false;
        }
        if ($thumb->writeImage($absolutPathDest)) {
            return false;    
        }
        $thumb->destroy();
        return true;
    }
}
?>
