<?php
/**
 * Description of EvaluationAttachmentContent
 *
 * @author ben.dokter
 */

require_once('modules/model/service/upload/AttachmentContent.class.php');

class EvaluationAttachmentContent extends AttachmentContent {


    function getAllowedUploadExtensions()
    {
        return array(".pdf", ".doc", ".docx", ".xls", ".xlsx"); // specify the allowed extensions here
    }

}

?>
