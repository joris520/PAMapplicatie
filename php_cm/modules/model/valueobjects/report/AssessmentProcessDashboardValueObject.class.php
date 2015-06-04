<?php

/**
 * Description of AssessmentProcessDashboardValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/AssessmentProcessDashboardCountValueObject.class.php');
require_once('modules/model/valueobjects/employee/assessmentAction/EmployeeAssessmentProcessValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentEvaluationValueObject.class.php');

require_once('modules/model/value/assessmentInvitation/AssessmentInvitationCompletedValue.class.php');
require_once('modules/model/value/employee/competence/ScoreStatusValue.class.php');

class AssessmentProcessDashboardValueObject extends AssessmentProcessDashboardCountValueObject
{
    private $bossName;

    static function create($bossId, $bossName)
    {
        return new AssessmentProcessDashboardValueObject($bossId, $bossName);
    }

    protected function __construct($bossId, $bossName)
    {
        parent::__construct($bossId);
        $this->bossName = $bossName;
    }

    // voorkeursmethode, met AssessmentProcessReportQueries::getProcessCountReportInPeriod
    function addCountData(Array $queryCountData)
    {
        $this->invitedTotal                 = $queryCountData['invitedTotal'];

        $this->phaseInvited                 = $queryCountData['phaseInvited'];
        $this->phaseSelectEvaluation        = $queryCountData['phaseSelectEvaluation'];
        $this->phaseEvaluation              = $queryCountData['phaseEvaluation'];

        $this->evaluationDoneNotRequested   = $queryCountData['evaluationDoneNotRequested'];

        $this->evaluationPlanned            = $queryCountData['evaluationPlanned'];
        $this->evaluationCancelled          = $queryCountData['evaluationCancelled'];
        $this->evaluationDone               = $queryCountData['evaluationDone'];
        $this->evaluationNotRequested       = $queryCountData['evaluationNotRequested'];
    }

    // "oude" methode via elke medewerker object tellen
    function addValues( AssessmentProcessDashboardDetailValueObject $processReportValueObject)
    {
        $processStatus          = $processReportValueObject->getAssessmentProcessStatus();
        $evaluationStatus       = $processReportValueObject->getAssessmentEvaluationStatus();
        $isEvaluationRequested  = $processReportValueObject->isEvaluationRequested();

        // alleen de actieve processen tellen
        if ($processStatus != AssessmentProcessStatusValue::UNUSED) {
            $this->invitedTotal++;
        }

        // de functioneringsgesprekken buiten de fase om
        if ($evaluationStatus == AssessmentEvaluationStatusValue::EVALUATION_DONE &&
            !$isEvaluationRequested) {
            $this->evaluationDoneNotRequested++;
        }

        switch ($processStatus) {
            case AssessmentProcessStatusValue::INVITED:
                $this->phaseInvited++;
                break;
            case AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED:
                $this->phaseSelectEvaluation++;
                break;
            case AssessmentProcessStatusValue::EVALUATION_SELECTED:
                $this->phaseEvaluation++;
                if ($isEvaluationRequested) {
                    // als de medewerker voor functioneringsgesprek is geselecteerd
                    // en in fase EVALUATION_SELECTED, dan de totalen bijwerken
                    switch($evaluationStatus) {
                        case AssessmentEvaluationStatusValue::EVALUATION_NO:
                            $this->evaluationPlanned++;
                            break;
                        case AssessmentEvaluationStatusValue::EVALUATION_CANCELLED:
                            $this->evaluationCancelled++;
                            break;
                        case AssessmentEvaluationStatusValue::EVALUATION_DONE:
                            $this->evaluationDone++;
                            break;
                    }
                } else {
                    $this->evaluationNotRequested++;
                }
                break;
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
