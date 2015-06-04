<?php

/**
 * Description of EmployeeCompetenceClusterScoreCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/library/AssessmentCycleValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceScoreCollection.class.php');

class EmployeeCompetenceClusterScoreCollection extends BaseCollection
{
    private $clusterId;
    private $assessmentCycleValueObject;

    private $competenceScoreCollections;
    private $clusterHasIncompleteScores;

    private $categoryName;
    private $clusterName;

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // AssessmentCycleValueObject
    static function create( $clusterId,
                            AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        return new EmployeeCompetenceClusterScoreCollection(    $clusterId,
                                                                $assessmentCycleValueObject);
    }

    function __construct(   $clusterId,
                            AssessmentCycleValueObject $assessmentCycleValueObject)
    {
        parent::__construct();
        $this->clusterId                    = $clusterId;
        $this->assessmentCycleValueObject   = $assessmentCycleValueObject;

        $this->clusterHasIncompleteScores  = false;
        $this->competenceScoreCollections = array();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getClusterId()
    {
        return $this->clusterId;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    function getCategoryName()
    {
        return $this->categoryName;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClusterName($clusterName)
    {
        $this->clusterName = $clusterName;
    }

    function getClusterName()
    {
        return $this->clusterName;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // AssessmentCycle
    function getAssessmentCycle()
    {
        return $this->assessmentCycleValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject->scoreStatus (ScoreStatusValue)
    function getScoreStatusValue()
    {
        return $this->scoreStatusValue;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // EmployeeAssessmentValueObject
    function addEmployeeScoreCollection($competenceId,
                                        EmployeeScoreCollection $employeeScoreCollection)
    {
        parent::addValueObject($employeeScoreCollection);
        $this->competenceScoreCollections[$competenceId] = $employeeScoreCollection;
    }

    function getEmployeeScoreCollections()
    {
        return $this->valueObjects;
    }

    function getEmployeeCompetenceScoreCollections()
    {
        return $this->competenceScoreCollections;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function markClusterHasIncompleteScores()
    {
        $this->clusterHasIncompleteScores = true;
    }

    function hasIncompleteScores()
    {
        return $this->clusterHasIncompleteScores;
    }

}

?>
