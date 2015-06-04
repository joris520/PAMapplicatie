<?php

/**
 * Description of DocumentClusterValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class DocumentClusterValueObject extends BaseValueObject
{
    var $clusterName;

    /**
     * Deze functie neemt een array met data (formaat van de database tabel)
     * @param type $assessmentQuestionData
     * @return DocumentClusterValueObject
     */
    static function createWithData( $documentClusterData)
    {
        return new DocumentClusterValueObject($documentClusterData[DocumentClusterQueries::ID_FIELD], $documentClusterData);
    }

    /**
     * Deze functie maakt van de losse values een valueObject
     * @param type $questionId
     * @param type $question
     * @param type $sortOrder
     * @return DocumentClusterValueObject
     */
    static function createWithValues(   $documentClusterId,
                                        $clusterName)
    {
        $documentClusterData = array();

        $documentClusterData[DocumentClusterQueries::ID_FIELD] = $documentClusterId;
        $documentClusterData['document_cluster']   = $clusterName;

        return new DocumentClusterValueObject($documentClusterId, $documentClusterData);
    }

    protected function __construct($documentClusterId, $documentClusterData)
    {
        parent::__construct($documentClusterId,
                            $documentClusterData['saved_by_user_id'],
                            $documentClusterData['saved_by_user'],
                            $documentClusterData['saved_datetime']);

        $this->clusterName = $documentClusterData['document_cluster'];
    }

}

?>
