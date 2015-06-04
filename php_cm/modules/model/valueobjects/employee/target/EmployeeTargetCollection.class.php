<?php

/**
 * Description of EmployeeTargetCollection
 *
 * @author hans.prins
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

class EmployeeTargetCollection extends BaseCollection
{
    private $assessmentCycleValueObject;

    static function create(AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        return new EmployeeTargetCollection($assessmentCycleValueObject);
    }

    function __construct(AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        parent::__construct();
        $this->assessmentCycleValueObject = $assessmentCycleValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function hasTargets()
    {
        return $this->hasValueObjects();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAssessmentCycleValueObject()
    {
        return $this->assessmentCycleValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeTargetValueObject
    function addEmployeeTargetValueObject(EmployeeTargetValueObject $valueObject)
    {
        $this->addValueObject($valueObject);
    }

    function getEmployeeTargetValueObjects()
    {
        return $this->getValueObjects();
    }

}

?>
