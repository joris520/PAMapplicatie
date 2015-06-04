<?php

/**
 * Description of AssessmentProcessDashboardCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/report/AssessmentProcessDashboardCountValueObject.class.php');

class AssessmentProcessDashboardCollection extends BaseCollection
{
    private $totalCountValueObject;

    static function create()
    {
        return new AssessmentProcessDashboardCollection();
    }

    protected function __construct()
    {
        parent::__construct();
        $this->totalCountValueObject = AssessmentProcessDashboardCountValueObject::create();
    }

    function addValueObject(AssessmentProcessDashboardValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
        // totalen bijwerken
        $this->totalCountValueObject->addInvitedTotal(                 $valueObject->getInvitedTotal());

        $this->totalCountValueObject->addPhaseInvited (                $valueObject->getPhaseInvited());
        $this->totalCountValueObject->addPhaseSelectEvaluation(        $valueObject->getPhaseSelectEvaluation());
        $this->totalCountValueObject->addPhaseEvaluation(              $valueObject->getPhaseEvaluation());

        $this->totalCountValueObject->addEvaluationNotRequested(       $valueObject->getEvaluationNotRequested());
        $this->totalCountValueObject->addEvaluationPlanned(            $valueObject->getEvaluationPlanned());
        $this->totalCountValueObject->addEvaluationCancelled(          $valueObject->getEvaluationCancelled());
        $this->totalCountValueObject->addEvaluationDone(               $valueObject->getEvaluationDone());
        $this->totalCountValueObject->addEvaluationDoneNotRequested(   $valueObject->getEvaluationDoneNotRequested());
    }

    function getTotalCountValueObject()
    {
        return $this->totalCountValueObject;
    }



}

?>
