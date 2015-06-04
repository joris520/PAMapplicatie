<?php

/**
 * Description of DocumentContentValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class DocumentContentValueObject extends BaseValueObject
{
    private $filename;
    private $fileExtension;
    private $contentSize;

    static function createWithData($documentContentId, $documentContentData)
    {
        return new DocumentContentValueObject($documentContentId, $documentContentData);
    }

    static function createWithValues(   $documentContentId,
                                        $filename,
                                        $fileExtension,
                                        $contentSize)
    {
        $documentContentData = array();

        $documentContentData[DocumentContentQueries::ID_FIELD] = $documentContentId;
        $documentContentData['filename']       = $filename;
        $documentContentData['file_extension'] = $fileExtension;
        $documentContentData['contents_size']  = $contentSize;

        return new DocumentContentValueObject($documentContentId, $documentContentData);
    }

    protected function __construct($documentContentId, $documentContentData)
    {
        parent::__construct($documentContentId,
                            $documentContentData['saved_by_user_id'],
                            $documentContentData['saved_by_user'],
                            $documentContentData['saved_datetime']);

        $this->filename      = $documentContentData['filename'];
        $this->fileExtension = $documentContentData['file_extension'];
        $this->contentSize   = $documentContentData['contents_size'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $filename
    function getFilename()
    {
        return $this->filename;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $fileExtension
    function getFileExtension()
    {
        return $this->fileExtension;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $contentSize
    function getContentSize()
    {
        return $this->contentSize;
    }


}

?>
