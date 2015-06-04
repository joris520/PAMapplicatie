<?php

/**
 * Description of DocumentContentService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/upload/DocumentContentQueries.class.php');
require_once('modules/model/valueobjects/upload/DocumentContentValueObject.class.php');

class DocumentContentService
{

    static function getValueObjectById($contentId)
    {
        $query = DocumentContentQueries::getDocumentContent($contentId);
        $contentData = mysql_fetch_assoc($query);

        return DocumentContentValueObject::createWithData($contentId, $contentData);
    }

    // TODO: deze wegrefactoren...
    protected static function getValueObjectByIdForCustomer($customerId, $contentId)
    {
        $query = DocumentContentQueries::getDocumentContentForCustomer($customerId, $contentId);
        $contentData = mysql_fetch_assoc($query);

        return DocumentContentValueObject::createWithData($contentId, $contentData);
    }

    static function getContentFromDatabase($contentId)
    {
        return base64_decode(self::getContentBase64FromDatabase($contentId));
    }

    static function getContentFromDatabaseForCustomer($customerId, $contentId)
    {
        return base64_decode(self::getContentBase64FromDatabaseForCustomer($customerId, $contentId));
    }

    static function getContentBase64FromDatabase($contentId)
    {
        $query = DocumentContentQueries::getDocumentContentBase64($contentId);
        $contentBase64Data = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $contentBase64Data['contentsBase64'];
    }

    // TODO: deze wegrefactoren...
    static function getContentBase64FromDatabaseForCustomer($customerId, $contentId)
    {
        $query = DocumentContentQueries::getDocumentContentBase64ForCustomer($customerId, $contentId);
        $contentBase64Data = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $contentBase64Data['contentsBase64'];
    }

    static function removeContentFromDatabase($contentId)
    {
        if (!empty($contentId)) {
            DocumentContentQueries::deleteDocumentContent($contentId);
        }
    }

    static function deleteContentFile($contentPath, $contentFile)
    {
         try {
            if (!empty($contentFile)) {
                @unlink($contentPath . $contentFile);
            }
        } catch (TimecodeException $ignore) {
            // bestond waarschijnlijk niet meer...
        }
    }

    // TODO: $customerId wegrefactoren...
    function copyContentToCustomerFilePath($customerId, $contentId, $filePath)
    {
        $contentValueObject = DocumentContentService::getValueObjectByIdForCustomer($customerId, $contentId);

        $contentSize = $contentValueObject->getContentSize();
        // converteren en wegschrijven content
        FileContent::writeImageContentToFile($filePath,
//                                             base64_decode(self::getContentBase64FromDatabaseForCustomer($customerId, $contentId)),
                                             self::getContentFromDatabaseForCustomer($customerId, $contentId),
                                             $contentSize);
    }


}

?>
