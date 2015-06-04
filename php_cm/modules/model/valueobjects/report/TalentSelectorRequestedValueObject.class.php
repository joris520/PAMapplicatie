<?php

/**
 * Description of TalentSelectorRequestedValueObject
 *
 * @author hans.prins
 */

class TalentSelectorRequestedValueObject
{
    private $competenceId;
    private $competenceName;
    private $operator;
    private $score;

    // factory method
    static function createWithData($talentSelectorRequestedData)
    {
        return new TalentSelectorRequestedValueObject($talentSelectorRequestedData);
    }

    static function createWithValues($competenceId, $competenceName, $operator, $score)
    {
        $talentSelectorRequestedData = array();
        $talentSelectorRequestedData['competenceId']   = $competenceId;
        $talentSelectorRequestedData['competenceName'] = $competenceName;
        $talentSelectorRequestedData['operator']       = $operator;
        $talentSelectorRequestedData['score']          = $score;
        return new TalentSelectorRequestedValueObject($talentSelectorRequestedData);
    }

    function __construct($talentSelectorRequestedData)
    {
        $this->competenceId   = $talentSelectorRequestedData['competenceId'];
        $this->competenceName = $talentSelectorRequestedData['competenceName'];
        $this->operator       = $talentSelectorRequestedData['operator'];
        $this->score          = $talentSelectorRequestedData['score'];
    }

    function setCompetenceId($competenceId)
    {
        $this->competenceId = $competenceId;
    }

    function getCompetenceId()
    {
        return $this->competenceId;
    }

    function setCompetenceName($competenceName)
    {
        $this->competenceName = $competenceName;
    }

    function getCompetenceName()
    {
        return $this->competenceName;
    }

    function setOperator($operator)
    {
        $this->operator = $operator;
    }

    function getOperator()
    {
        return $this->operator;
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
