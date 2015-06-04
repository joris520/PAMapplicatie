<?php

/**
 * Description of FileContent
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/to_refactor/DocumentQueries.class.php');

abstract class FileContent {

    var $id_contents = 'null';
    var $local_name = '';
    var $document_name = '';
    var $document_extension = '';
    var $message = '';

    abstract function getAllowedUploadExtensions();
    abstract function getMaxUploadFileSize();
    abstract function processFileContent($tempfile_name, $upload_mime, $document_name, $document_extension);

    function getAllowedUploadExtensionsText() {
        return implode(", ", $this->getAllowedUploadExtensions());
    }

    function isAllowedFileType($s_extension, $a_extensions=null) {
        if(strpos('.', $s_extension) === false) {
            $s_extension = '.' . $s_extension;
        }

        if (empty($a_extensions)) {
            $a_extensions = $this->getAllowedUploadExtensions();
        }
        return in_array($s_extension, $a_extensions);
    }

    function hasFileAllowedExtension($s_file_name, $a_extensions=null) {
        $hasAllowed = false;

        $fileinfo = pathinfo($s_file_name);

        if (!empty($fileinfo['extension'])) {
            $hasAllowed = $this->isAllowedFileType($fileinfo['extension'], $a_extensions);
        }

        return $hasAllowed;
    }

    static function getDecodedContents($file_contents)
    {
        return base64_decode($file_contents);
    }

    static function writeImageContentToFile($image_file, $image_content, $image_size)
    {
        // TODO: error handling als er niet geschreven kan worden
       // die('$image_file'.$image_file. ' $image_size'.$image_size.' $image_content'.$image_content);
        $hasError = false;
        if (!$file_handle = fopen($image_file, 'wb')) { // binair schrijven, zonder lf/cr vertalingen
            $this->message = 'fopen(' . $image_file . ')';
            $hasError = true;
        } else {
            if (fwrite($file_handle, $image_content, $image_size) === FALSE) {
                $this->message = 'fwrite(' . $image_file . ')';
                $hasError = true;
            } else {
                fclose($file_handle);
            }
        }
        return $hasError;

    }


    static function isValidMimeTypeForExtension($mime_type, $file_extension)
    {
        $extension_mime_types = FileContent::getMimeTypesForExtension($file_extension);
        return (in_array($mime_type, $extension_mime_types));
    }

    static function getMimeTypesForExtension($file_extension)
    {
        $mime_types = '';
        switch ($file_extension) {
            case 'pdf':
                $mime_types = array('application/pdf');
                break;
            case 'png':
                $mime_types = array('image/png');
                break;
            case 'jpeg':
            case 'jpg':
                $mime_types = array('image/jpg', 'image/pjpeg', 'image/jpeg');
                break;
            case 'zip':
                $mime_types = array('application/zip');
                break;
            case 'doc':
                $mime_types = array('application/msword');
                break;
            case 'docx':
                $mime_types = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                break;
            case 'xls':
                $mime_types = array('application/vnd.ms-excel');
                break;
            case 'xlsx':
                $mime_types = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                break;
            case 'gif':
                $mime_types = array('image/gif');
                break;
            case 'ppt':
                $mime_types = array('application/vnd.ms-powerpoint');
                break;
            case 'pptx':
                $mime_types = array('application/vnd.openxmlformats-officedocument.presentationml.presentation');
                break;
            case 'txt':
                $mime_types = array('text/plain');
                break;
            default:
                $mime_types = array('application/force-download');
        }
        return $mime_types;
    }



    static function moveFileToDatabase($full_path, $document_name, $file_extension)
    {
        $content_id = FileContent::copyFileToDatabase($full_path, $document_name, $file_extension);
        if ($content_id > 0) { // todo: gebruik maken van exceptions
            unlink($full_path);
        }
        return $content_id;

    }

    static function copyFileToDatabase($full_path, $document_name, $file_extension)
    {
        $content_id = 0;
        $file_contents = file_get_contents($full_path); // todo: maxlen check!
        if ($file_contents !== FALSE) {
            $file_size = filesize($full_path);
            $content_id = 0;
            if ($file_contents) {
                $content_id =  FileContent::insertContentInDatabase($document_name, $file_extension, $file_contents, $file_size);
            }
        }
        return $content_id;
    }

    static function insertContentInDatabase($document_name, $file_extension, $contents, $contents_size)
    {
        $content_id =  DocumentQueries::insertDocumentContents($document_name, $file_extension, $contents, $contents_size);
        return $content_id;
    }

    static function removeContentFromDatabase($contentId)
    {
        if (!empty($contentId)) {
            DocumentQueries::deleteDocumentContent($contentId);
        }
    }

    static function generateLocalFilename()
    {
        sleep(3);
        return strtotime('now');
    }

    static function doUploadFile($tempfile_name, $document_name, $file_extension)
    {
        return FileContent::copyFileToDatabase($tempfile_name, $document_name, $file_extension);
    }

    function makeSafeDocumentname($uploaded_name)
    {
        $pathinfo = pathinfo($uploaded_name);
        $document_name = $pathinfo['basename'];
        $this->document_name =  preg_replace('/[^A-Za-z0-9_\%\[\]\-. \(\)]/', '_', $document_name, strlen($document_name));
        $this->document_extension = '' . strtolower($pathinfo['extension']);
    }

    static function getDocumentnameMaxLength()
    {
        return MAX_DOCUMENTNAME_LENGTH;
    }

    static function isValidDocumentnameLength($document_name)
    {
        return (strlen($document_name) <= MAX_DOCUMENTNAME_LENGTH);
    }

    static function hasValidFileSize($tempfile_name, $tempfile_size)
    {
        $checked_size = filesize($tempfile_name);
        return ($checked_size !== FALSE &&  $checked_size == $tempfile_size);
    }

    static function copyFileToLocalUploads($tempfile_name, $local_name)
    {
        $moved = false;
        $destination_dir = UPLOAD_PATH;
        if (file_exists($destination_dir)) {
            $moved = copy($tempfile_name, $local_name);
        }
        return $moved;
    }


    function uploadAndProcessFile()
    {
        $hasError = false;
        $this->message = '';

        // de specifieke file info uit $_FILES halen
        $uploaded_file_info = $_FILES['upload'];
        $upload_error_code  = intval($uploaded_file_info['error']);
        if ($upload_error_code == 0) {
            $tempfile_name = $uploaded_file_info['tmp_name'];
            $tempfile_size = $uploaded_file_info['size'];

            // TODO: exceptions gebruiken
            if (FileContent::hasValidFileSize($tempfile_name, $tempfile_size)) {

                $this->makeSafeDocumentname($uploaded_file_info['name']);
                if (FileContent::isValidDocumentnameLength($this->document_name)) {
                    $upload_mime   = $uploaded_file_info['type'];

                    if (FileContent::isValidMimeTypeForExtension($upload_mime, $this->document_extension)) {
                        // ok, hier kunnen we "veilig" verder verwerken
                        $hasError = $this->processFileContent($tempfile_name, $upload_mime, $this->document_name, $this->document_extension);
                        //$message =  $id_contents, $local_name)
                    } else {
                        $hasError = true;
                        $this->message = TXT_UCF('FILE_INVALID_EXTENSION');
                    }
                } else {
                    $hasError = true;
                    $this->message = TXT_UCF('FILE_NAME_TOO_LONG') . ' (max. = ' . FileContent::getDocumentnameMaxLength() . ')';
                }
            } else {
                $hasError = true;
                $this->message = TXT_UCF('FILE_INVALID_SIZE');
            }
        } else {
            $hasError = true;
            $this->message = FileContent::getErrorMessage($upload_error_code);
        }
        return $hasError;
    }

    static function getErrorMessage($error_code)
    {
        $error_message = '';
        switch($error_code) {
            case UPLOAD_ERR_OK:
                $error_message = 'ok.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message = TXT_UCF('ERROR_NO_FILE_SELECTED');
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_message = TXT_UCF('ERROR_FILE_TOO_LARGE');
                break;
            default:
                $error_message = TXT_UCF('ERROR_UPLOAD_FAILED');
        }
        return $error_message;
    }


}
?>
