<?php

/**
 * Description of EmployeeAssessmentCycleDetailPrintOptionValueObject
 *
 * @author hans.prins
 */

require_once('modules/print/valueobjects/BaseDetailPrintOptionValueObject.class.php');

class EmployeeAssessmentCycleDetailPrintOptionValueObject extends BaseDetailPrintOptionValueObject
{
    private $assessmentCycleOption;

    static function create()
    {
        return new EmployeeAssessmentCycleDetailPrintOptionValueObject();
    }

    protected function __construct()
    {
        parent::__construct();
        $this->assessmentCycleOption = EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentCycleOption($assessmentCycleOption)
    {
        $this->assessmentCycleOption = $assessmentCycleOption;
    }

    function getAssessmentCycleOption()
    {
        return $this->assessmentCycleOption;
    }
}

?>
