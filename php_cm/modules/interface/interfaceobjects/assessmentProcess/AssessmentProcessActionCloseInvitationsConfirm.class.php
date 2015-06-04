<?php

/**
 * Description of AssessmentProcessActionCloseInvitationsConfirm
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentProcessActionCloseInvitationsConfirm extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/assessmentProcessActionCloseInvitationsConfirm.tpl';

    private $selfAssessmentsNotCompletedCount;
    private $assessmentsNotCompletedCount;
    private $bossLabel;
    private $youLabel;

    static function create($displayWidth)
    {
        return new AssessmentProcessActionCloseInvitationsConfirm(  $displayWidth,
                                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSelfAssessmentsNotCompletedCount($selfAssessmentsNotCompletedCount)
    {
        $this->selfAssessmentsNotCompletedCount = $selfAssessmentsNotCompletedCount;
    }

    function getSelfAssessmentsNotCompletedCount()
    {
        return $this->selfAssessmentsNotCompletedCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentsNotCompletedCount($assessmentsNotCompletedCount)
    {
        $this->assessmentsNotCompletedCount = $assessmentsNotCompletedCount;
    }

    function getAssessmentsNotCompletedCount()
    {
        return $this->assessmentsNotCompletedCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBossLabel($bossLabel)
    {
        $this->bossLabel = $bossLabel;
    }

    function getBossLabel()
    {
        return $this->bossLabel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setYouLabel($youLabel)
    {
        $this->youLabel = $youLabel;
    }

    function getYouLabel()
    {
        return $this->youLabel;
    }

}

?>
