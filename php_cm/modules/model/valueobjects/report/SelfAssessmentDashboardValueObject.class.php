<?php

/**
 * Description of SelfAssessmentDashboard
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/report/SelfAssessmentDashboardCountValueObject.class.php');

require_once('modules/model/valueobjects/report/SelfAssessmentReportInvitationValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentValueObject.class.php');

require_once('modules/model/value/assessmentInvitation/AssessmentInvitationCompletedValue.class.php');
require_once('modules/model/value/employee/competence/ScoreStatusValue.class.php');

class SelfAssessmentDashboardValueObject extends SelfAssessmentDashboardCountValueObject
{
    private $bossName;

    static function create($bossId, $bossName)
    {
        return new SelfAssessmentDashboardValueObject($bossId, $bossName);
    }

    protected function __construct($bossId, $bossName)
    {
        parent::__construct($bossId);
        $this->bossName = $bossName;
    }

    function addValues( SelfAssessmentReportInvitationValueObject $valueObject,
                        EmployeeAssessmentValueObject $assessmentValueObject)
    {
        $this->invitedTotal++;
        $employeeCompleted = false;
        switch ($valueObject->getCompletedStatus())
        {
            case AssessmentInvitationCompletedValue::NOT_COMPLETED:
                $this->employeeNotCompleted++;
                break;
            case AssessmentInvitationCompletedValue::COMPLETED:
                $this->employeeCompleted++;
                $employeeCompleted = true;
                break;
            case AssessmentInvitationCompletedValue::RESULT_DELETED:
                $this->employeeDeleted++;
                $employeeCompleted = true;
                break;
        }
        $bossCompleted = false;
        switch ($assessmentValueObject->getScoreStatus())
        {
            case ScoreStatusValue::FINALIZED:
                $this->bossCompleted++;
                $bossCompleted = true;
                break;
            case ScoreStatusValue::PRELIMINARY:
            default:
                $this->bossNotCompleted++;
                break;
        }
        if ($employeeCompleted && $bossCompleted) {
            $this->bothCompleted++;
        }

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getBossId()
    {
        return $this->getId();
    }

    function getBossName()
    {
        return $this->bossName;
    }

}

?>
