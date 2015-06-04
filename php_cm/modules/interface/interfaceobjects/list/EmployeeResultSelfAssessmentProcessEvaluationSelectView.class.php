<?php

/**
 * Description of EmployeeResultSelfAssessmentProcessEvaluationSelectView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/list/EmployeeResultSelfAssessmentProcessView.class.php');

class EmployeeResultSelfAssessmentProcessEvaluationSelectView extends EmployeeResultSelfAssessmentProcessView
{
    const TEMPLATE_FILE = 'list/resultViewDetail/assessmentProcess/employeeResultSelfAssessmentProcessEvaluationSelectView.tpl';
//    const TEMPLATE_FILE = 'list/resultViewDetail/assessmentProcess/evaluationSelectDetailView.tpl';

    private $color;
    private $isEvaluationRequested;
    private $scoreRank;

    // checkbox evaluation request
    private $checkBoxHtmlId;
    private $checkBoxColorHtmlId;
    private $checkBoxOnClick;

    static function create( $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth)
    {
        return new EmployeeResultSelfAssessmentProcessEvaluationSelectView( $employeeId,
                                                                            $employeeName,
                                                                            $employeeNameHtmlId,
                                                                            $displayWidth,
                                                                            self::TEMPLATE_FILE);
    }

    //////////////////////////
    // color
    function setColor($color)
    {
        $this->color = $color;
    }

    function getColor()
    {
        return $this->color;
    }

    function hasColor()
    {
        return !empty($this->color);
    }

    //////////////////////////
    // selected
    function setIsEvaluationRequested($isEvaluationRequested)
    {
        $this->isEvaluationRequested = $isEvaluationRequested;
    }

    function getIsEvaluationRequested()
    {
        return $this->isEvaluationRequested;
    }

    function isEvaluationRequested()
    {
        return !empty($this->isEvaluationRequested);
    }

    //////////////////////////
    // $scoreRank
    function setScoreRank($scoreRank)
    {
        $this->scoreRank = $scoreRank;
    }

    function getScoreRank()
    {
        return $this->scoreRank;
    }

    //////////////////////////
    // $checkBoxHtmlId
    function setCheckBoxHtmlId($checkBoxHtmlId)
    {
        $this->checkBoxHtmlId = $checkBoxHtmlId;
    }

    function getCheckBoxHtmlId($employeeId)
    {
        return $this->checkBoxHtmlId . $employeeId;
    }

    //////////////////////////
    // $checkBoxHtmlId
    function setCheckBoxColorHtmlId($checkBoxColorHtmlId)
    {
        $this->checkBoxColorHtmlId = $checkBoxColorHtmlId;
    }

    function getCheckBoxColorHtmlId($employeeId)
    {
        return $this->checkBoxColorHtmlId . $employeeId;
    }

    //////////////////////////
    // $checkBoxOnClick
    function setCheckBoxOnClick($checkBoxOnClick)
    {
        $this->checkBoxOnClick = $checkBoxOnClick;
    }

    function getCheckBoxOnClick()
    {
        return $this->checkBoxOnClick;
    }



}

?>
