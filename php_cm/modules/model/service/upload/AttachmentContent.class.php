<?php
/**
 * Description of AttachmentContent
 *
 * @author ben.dokter
 */

require_once('modules/model/service/upload/FileContent.class.php');

class AttachmentContent extends FileContent {

    function processFileContent($tempfile_name, $upload_mime, $document_name, $document_extension)
    {
        $this->message = TXT_UCF('FILE_ADDED_AS_ATTACHMENT');
        $this->local_name = '';
        $this->id_contents = FileContent::copyFileToDatabase($tempfile_name, $document_name, $document_extension);
        if ($this->id_contents <= 0) {
            $this->has_error = true;
            $this->message = TXT_UCF('CANNOT_STORE_FILE_IN_DATABASE');
        }
        return $this->has_error;
        //return array($hasError, $message, $id_contents, $local_name);
    }

    function getAllowedUploadExtensions()
    {
        return array(".jpg", ".png", ".gif", ".pdf", ".txt", ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".zip"); // specify the allowed extensions here
    }

    function getMaxUploadFileSize()
    {
        return MAX_ATTACHMENT_BYTESIZE;
    }

    function getMaxUploadFileSizeLabel()
    {
        return ($this->getMaxUploadFileSize()/1024) . ' kB';
    }

}

?>
