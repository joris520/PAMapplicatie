<?php

/**
 * Description of EmployeeCompetenceScoreCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

class EmployeeCompetenceScoreCollection extends BaseCollection
{
    private $currentPeriod;
    private $previousPeriod;
    private $currentScoreStatusValue;
    private $previousScoreStatusValue;
    private $employeeCompetenceValueObject;

    private $employeeScoreValueObject;
    private $hasIncompleteScores;
    private $previousEmployeeScoreValueObject;

    private $employeeSelfAssessmentScoreValueObject;
    private $previousEmployeeSelfAssessmentScoreValueObject;


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeCompetenceValueObject
    // EmployeeAssessmentValueObject->scoreStatus
    static function create( EmployeeCompetenceValueObject $employeeCompetenceValueObject,
                            $currentPeriod,
                            $previousPeriod,
                            $currentScoreStatus,
                            $previousScoreStatus)
    {
        return new EmployeeCompetenceScoreCollection(   $employeeCompetenceValueObject,
                                                        $currentPeriod,
                                                        $previousPeriod,
                                                        $currentScoreStatus,
                                                        $previousScoreStatus);
    }

    function __construct(   EmployeeCompetenceValueObject $employeeCompetenceValueObject,
                            $currentPeriod,
                            $previousPeriod,
                            $currentScoreStatusValue,
                            $previousScoreStatusValue)
    {
        parent::__construct();
        $this->employeeCompetenceValueObject    = $employeeCompetenceValueObject;
        $this->currentPeriod                    = $currentPeriod;
        $this->previousPeriod                   = $previousPeriod;
        $this->currentScoreStatusValue          = $currentScoreStatusValue;
        $this->previousScoreStatusValue         = $previousScoreStatusValue;
        $this->hasIncompleteScores              = false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeCompetenceValueObject
    function getEmployeeCompetenceValueObject()
    {
        return $this->employeeCompetenceValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // AssessmentCycle
    function getAssessmentPeriods()
    {
        return array(   $this->currentPeriod,
                        $this->previousPeriod);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject->scoreStatus (ScoreStatusValue)
    function getScoreStatusValues()
    {
        return array(   $this->currentScoreStatusValue,
                        $this->previousScoreStatusValue);
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject
    function setEmployeeScoreValueObjects(  EmployeeScoreValueObject $valueObject,
                                            EmployeeScoreValueObject $previousValueObject)
    {
        $this->employeeScoreValueObject = $valueObject;
        $this->previousEmployeeScoreValueObject = $previousValueObject;
    }

    function getEmployeeScoreValueObjects()
    {
        return array(   $this->employeeScoreValueObject,
                        $this->previousEmployeeScoreValueObject);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function markIncompleteScore()
    {
        $this->hasIncompleteScores = true;
    }

    function hasIncompleteScores()
    {
        return $this->hasIncompleteScores;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeSelfAssessmentScoreValueObject
    function setEmployeeSelfAssessmentScoreValueObjects(EmployeeSelfAssessmentScoreValueObject $valueObject,
                                                        EmployeeSelfAssessmentScoreValueObject $previousValueObject)
    {
        $this->employeeSelfAssessmentScoreValueObject = $valueObject;
        $this->previousEmployeeSelfAssessmentScoreValueObject = $previousValueObject;
    }

    function getEmployeeSelfAssessmentScoreValueObjects()
    {
        return array(   $this->employeeSelfAssessmentScoreValueObject,
                        $this->previousEmployeeSelfAssessmentScoreValueObject);
    }

}

?>
