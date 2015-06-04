<?php

/**
 * Description of TalentSelectorValueObject
 *
 * @author hans.prins
 */
require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class TalentSelectorValueObject extends BaseReportValueObject
{
    public $employeeId;
    public $employeeName;
    public $score;

    // factory method
    static function createWithData($employeeCompetenceScoreData)
    {
        return new TalentSelectorValueObject($employeeCompetenceScoreData);
    }

    static function createWithValues($employeeId, $employeeName, $score)
    {
        $employeeCompetenceScoreData = array();
        $employeeCompetenceScoreData['employeeId']   = $employeeId;
        $employeeCompetenceScoreData['employeeName'] = $employeeName;
        $employeeCompetenceScoreData['score']        = $score;
        return new TalentSelectorValueObject($employeeCompetenceScoreData);
    }

    function __construct($employeeCompetenceScoreData)
    {
        parent::__construct();

        $this->employeeId   = $employeeCompetenceScoreData['employeeId'];
        $this->employeeName = $employeeCompetenceScoreData['employeeName'];
        $this->score        = $employeeCompetenceScoreData['score'];
    }

    function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    function getEmployeeId()
    {
        return $this->employeeId;
    }

    function setEmployeeName($employeeName)
    {
        $this->employeeName = $employeeName;
    }

    function getEmployeeName()
    {
        return $this->employeeName;
    }

    function setScore($score)
    {
        $this->score = $score;
    }

    function getScore()
    {
        return $this->score;
    }
}

?>
