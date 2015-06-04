<?php

/**
 * Description of EmployeeCompetenceCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

class EmployeeCompetenceCollection extends BaseCollection
{
    private $currentAssessmentCycle;
    private $previousAssessmentCycle;

    private $employeeAssessmentEvaluationValueObject;
    private $employeeAssessmentValueObject;
    private $previousEmployeeAssessmentValueObject;
    private $employeeCompetenceScoreCollections;
    private $employeeJobProfileValueObject;

    private $employeeAnswerCollection;
    private $assessmentCollection;
    private $previousAssessmentCollection;

    private $currentEmployeeCompetenceCategoryClusterScoreCollection;
    private $previousEmployeeCompetenceCategoryClusterScoreCollection;

    static function create( AssessmentCycleValueObject $currentAssessmentCycle,
                            AssessmentCycleValueObject $previousAssessmentCycle)
    {
        return new EmployeeCompetenceCollection($currentAssessmentCycle,
                                                $previousAssessmentCycle);
    }

    function __construct(   AssessmentCycleValueObject $currentAssessmentCycle,
                            AssessmentCycleValueObject $previousAssessmentCycle)
    {
        parent::__construct();
        $this->currentAssessmentCycle = $currentAssessmentCycle;
        $this->previousAssessmentCycle = $previousAssessmentCycle;
        $this->employeeAnswerValueObjects = array();
        $this->employeeCompetenceScoreCollections = array();
        $this->employeeCompetenceCategoryClusterScoreCollections = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCurrentAssessmentCycle()
    {
        return $this->currentAssessmentCycle;
    }

    function getPreviousAssessmentCycle()
    {
        return $this->previousAssessmentCycle;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAnswerValueObject
    function setEmployeeAnswerCollection(EmployeeAnswerCollection $collection)
    {
        $this->employeeAnswerCollection = $collection;
    }

    function getEmployeeAnswerCollection()
    {
        return $this->employeeAnswerCollection;
    }

//    function addEmployeeAnswerValueObject(EmployeeAnswerValueObject $valueObject)
//    {
//        $this->employeeAnswerValueObjects[] = $valueObject;
//    }
//
//    function getEmployeeAnswerValueObjects()
//    {
//        return $this->employeeAnswerValueObjects;
//    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeCompetenceScoreCollections()
    {
        return $this->employeeCompetenceScoreCollections;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeCompetenceCategoryClusterScoreCollection
    function setEmployeeCompetenceCategoryClusterScoreCollections(  EmployeeCompetenceCategoryClusterScoreCollection $currentCollection,
                                                                    EmployeeCompetenceCategoryClusterScoreCollection $previousCollection)
    {
        $this->currentEmployeeCompetenceCategoryClusterScoreCollection  = $currentCollection;
        $this->previousEmployeeCompetenceCategoryClusterScoreCollection = $previousCollection;
    }

    function getCurrentEmployeeCompetenceCategoryClusterScoreCollection()
    {
        return $this->currentEmployeeCompetenceCategoryClusterScoreCollection;
    }

    function getPreviousEmployeeCompetenceCategoryClusterScoreCollection()
    {
        return $this->previousEmployeeCompetenceCategoryClusterScoreCollection;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentEvaluationValueObject
    function setEmployeeAssessmentEvaluationValueObject(EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        $this->employeeAssessmentEvaluationValueObject = $valueObject;
    }

    function getEmployeeAssessmentEvaluationValueObject()
    {
        return $this->employeeAssessmentEvaluationValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject
    function setEmployeeAssessmentValueObjects( EmployeeAssessmentValueObject $currentValueObject,
                                                EmployeeAssessmentValueObject $previousValueObject)
    {
        $this->employeeAssessmentValueObject            = $currentValueObject;
        $this->previousEmployeeAssessmentValueObject    = $previousValueObject;
    }

    function getEmployeeAssessmentValueObject()
    {
        return $this->employeeAssessmentValueObject;
    }

    function getPreviousEmployeeAssessmentValueObject()
    {
        return $this->previousEmployeeAssessmentValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeJobProfileValueObject
    function setEmployeeJobProfileValueObject(EmployeeJobProfileValueObject $valueObject)
    {
        $this->employeeJobProfileValueObject = $valueObject;
    }

    function getEmployeeJobProfileValueObject()
    {
        return $this->employeeJobProfileValueObject;
    }

    function setAssessmentCollections(  EmployeeAssessmentCollection $assessmentCollection,
                                        EmployeeAssessmentCollection $previousAssessmentCollection)
    {
        $this->assessmentCollection         = $assessmentCollection;
        $this->previousAssessmentCollection = $previousAssessmentCollection;
    }

    function getAssessmentCollection()
    {
        return $this->assessmentCollection;
    }

    function getPreviousAssessmentCollection()
    {
        return $this->previousAssessmentCollection;
    }
}

?>
