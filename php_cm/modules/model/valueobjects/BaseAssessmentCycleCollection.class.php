<?php

/**
 * Description of BaseAssessmentCycleCollection
 *
 * @author ben.dokter
 */

class BaseAssessmentCycleCollection
{
    protected $assessmentCycleValueObject;

    protected function __construct(AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        $this->assessmentCycleValueObject = $assessmentCycleValueObject;
    }

    function getAssessmentCycleValueObject()
    {
        return $this->assessmentCycleValueObject;
    }

    function hasAssessmentCycle()
    {
        return !empty($this->assessmentCycleValueObject) && ($this->assessmentCycleValueObject->getId() != NULL);
    }
}

?>
