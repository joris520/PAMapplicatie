<?php

/**
 * Description of EmployeeDocumentService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/employee/document/EmployeeDocumentQueries.class.php');

require_once('modules/model/queries/to_refactor/DocumentQueries.class.php');

class EmployeeDocumentService
{

    static function getValueObjects($employeeId)
    {
        $valueObjects = array();

        $query = EmployeeDocumentQueries::getEmployeeDocuments($employeeId);
        while ($attachmentInfoData = @mysql_fetch_assoc($query)) {
            $valueObject = EmployeeDocumentValueObject::createWithData($attachmentInfoData);
            $attachmentCluster = $valueObject->getDocumentClusterId();
            $valueObjects[$attachmentCluster] = $valueObject;
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    
    static function getDocumentData($employeeId,
                                    $employeeDocumentId)
    {
        $query = EmployeeDocumentQueries::getEmployeeDocuments( $employeeId,
                                                                $employeeDocumentId);
        $documentInfoData = @mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $documentInfoData;
    }


    static function removeDocument( $employeeId,
                                    $employeeDocumentId)
    {
        $employeeDocumentData = @mysql_fetch_assoc(DocumentQueries::getEmployeeDocumentContentInfo( $employeeDocumentId,
                                                                                                    $employeeId));

        $document_pad =  $employeeDocumentData['document_pad'];
        $document_id_contents =  $employeeDocumentData['id_contents'];

        // attachment kan nu weg bij employee, en dan bestand zelf evt ook.
        DocumentQueries::deleteEmployeeDocuments($employeeDocumentId, $employeeId);
        //        BatchQueries::clearAssessmentEvaluationAttachment($employeeId, $employeeDocumentId);

        EmployeeAttachmentsServiceDeprecated::DeleteAttachment($document_pad, $document_id_contents);
    }

}

?>
