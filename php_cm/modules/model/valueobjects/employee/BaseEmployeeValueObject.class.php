<?php

/**
 * Description of BaseEmployeeValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class BaseEmployeeValueObject extends BaseValueObject
{
    protected $employeeId;

    protected $assessmentCycleValueObject;


    protected function __construct( $employeeId,
                                    $databaseId,
                                    $savedByUserId,
                                    $savedByUserName,
                                    $savedDateTime)
    {
        parent::__construct($databaseId, $savedByUserId, $savedByUserName, $savedDateTime);

        $this->employeeId = $employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeId()
    {
        return $this->employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentCycleValueObject(AssessmentCycleValueObject $assessmentCycleValueObject)
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

    function getAssessmentCycleName()
    {
        return $this->assessmentCycleValueObject->getAssessmentCycleName();
    }

    function getCycleId()
    {
        return $this->assessmentCycleValueObject->getId();
    }

}

?>
