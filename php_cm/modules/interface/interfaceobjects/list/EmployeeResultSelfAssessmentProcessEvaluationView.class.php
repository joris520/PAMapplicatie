<?php

/**
 * Description of EmployeeResultSelfAssessmentProcessEvaluationView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/list/EmployeeResultSelfAssessmentProcessView.class.php');

class EmployeeResultSelfAssessmentProcessEvaluationView extends EmployeeResultSelfAssessmentProcessView
{
    const TEMPLATE_FILE = 'list/resultViewDetail/assessmentProcess/employeeResultSelfAssessmentProcessEvaluationView.tpl';

    private $statusIconView;

    static function create( $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth)
    {
        return new EmployeeResultSelfAssessmentProcessEvaluationView(   $employeeId,
                                                                        $employeeName,
                                                                        $employeeNameHtmlId,
                                                                        $displayWidth,
                                                                        self::TEMPLATE_FILE);
    }

    //////////////////////////
    // iconView
    function setStatusIconView(AssessmentIconView $statusIconView)
    {
        $this->statusIconView = $statusIconView;
    }

    function getStatusIconHtml()
    {
        return !empty($this->statusIconView) ? $this->statusIconView->fetchHtml() : '';
    }

}

?>
