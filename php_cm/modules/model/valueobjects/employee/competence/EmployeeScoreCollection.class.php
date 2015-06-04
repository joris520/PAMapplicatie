<?php

/**
 * Description of EmployeeScoreCollection
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeCompetenceValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeScoreValueObject.class.php');

class EmployeeScoreCollection extends BaseCollection
{
    // welke competentie
    private $competenceValueObject;

    private $hasIncompleteScore;

    // scores
    private $scoreValueObject;
    // self assessment
    private $selfAssessmentScoreValueObject;

    static function create(EmployeeCompetenceValueObject $competenceValueObject)
    {
        return new EmployeeScoreCollection($competenceValueObject);
    }

    protected function __construct(EmployeeCompetenceValueObject $competenceValueObject)
    {
        parent::__construct();
        $this->competenceValueObject = $competenceValueObject;
        $this->hasIncompleteScore = false; // positief benaderen
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Competence
    function getCompetenceValueObject()
    {
        return $this->competenceValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Score
    function setScoreValueObject(  EmployeeScoreValueObject $scoreValueObject)
    {
        $this->scoreValueObject  = $scoreValueObject;
    }

    function getScoreValueObject()
    {
        return $this->scoreValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SelfAssessment
    function setSelfAssessmentScoreValueObject( EmployeeSelfAssessmentScoreValueObject $selfAssessmentScoreValueObject)
    {
        $this->selfAssessmentScoreValueObject  = $selfAssessmentScoreValueObject;
    }

    function getSelfAssessmentScoreValueObject()
    {
        return $this->selfAssessmentScoreValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function markIncompleteScore($hasIncompleteScore)
    {
        $this->hasIncompleteScore = $hasIncompleteScore;
    }

    function hasIncompleteScore()
    {
        return $this->hasIncompleteScore;
    }

}

?>
