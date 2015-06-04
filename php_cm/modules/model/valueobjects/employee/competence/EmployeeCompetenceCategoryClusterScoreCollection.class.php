<?php

/**
 * Description of EmployeeCompetenceCategoryClusterScoreCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/library/AssessmentCycleValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceScoreCollection.class.php');

class EmployeeCompetenceCategoryClusterScoreCollection extends BaseCollection
{
    private $assessmentCycleValueObject;
    private $jobProfileValueObject;

    // assessment Info
    private $assessmentDate;
    private $scoreStatusValue;

    private $categoryClusterScoreCollections;

    private $categoryNames;

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // AssessmentCycleValueObject
    // EmployeeAssessmentValueObject->scoreStatus
    static function create( AssessmentCycleValueObject $assessmentCycleValueObject,
                            EmployeeJobProfileValueObject $jobProfileValueObject,
                            $assessmentDate,
                            $scoreStatusValue)
    {
        return new EmployeeCompetenceCategoryClusterScoreCollection(    $assessmentCycleValueObject,
                                                                        $jobProfileValueObject,
                                                                        $assessmentDate,
                                                                        $scoreStatusValue);
    }

    protected function __construct( AssessmentCycleValueObject $assessmentCycleValueObject,
                                    EmployeeJobProfileValueObject $jobProfileValueObject,
                                    $assessmentDate,
                                    $scoreStatusValue)
    {
        parent::__construct();
        $this->assessmentCycleValueObject   = $assessmentCycleValueObject;
        $this->jobProfileValueObject        = $jobProfileValueObject;
        $this->assessmentDate               = $assessmentDate;
        $this->scoreStatusValue             = $scoreStatusValue;

        $this->categoryClusterScoreCollections = array();
        $this->categoryNames = array();
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCategoryIds()
    {
        return array_keys($this->categoryClusterScoreCollections);
    }

    function getCategoryName($categoryId)
    {
        return $this->categoryNames[$categoryId];
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCategoryClusterIds($categoryId)
    {
        return array_keys($this->categoryClusterScoreCollections[$categoryId]);
    }

    function getCategoryClusters($categoryId)
    {
        return $this->categoryClusterScoreCollections[$categoryId];
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // AssessmentCycle
    function getAssessmentCycle()
    {
        return $this->assessmentCycleValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function getAssessmentDate()
    {
        return $this->assessmentDate;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject->scoreStatus (ScoreStatusValue)
    function getScoreStatusValue()
    {
        return $this->scoreStatusValue;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject
    function addEmployeeClusterScoreCollection( $categoryId,
                                                $categoryName,
                                                $clusterId,
                                                EmployeeCompetenceClusterScoreCollection $employeeClusterScoreCollection)
    {
        $this->categoryClusterScoreCollections[$categoryId][$clusterId] = $employeeClusterScoreCollection;
        $this->categoryNames[$categoryId]   = $categoryName;
    }

    function getEmployeeClusterScoreCollection( $categoryId,
                                                $clusterId)
    {
        return $this->categoryClusterScoreCollections[$categoryId][$clusterId];
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getJobProfileValueObject()
    {
        return $this->jobProfileValueObject;
    }
}

?>
