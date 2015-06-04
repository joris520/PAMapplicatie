<?php

/**
 * Description of EmployeeSelfAssessmentBatchInvite
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeSelfAssessmentBatchInvite extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'batch/employeeSelfAssessmentBatchInvite.tpl';

    private $cycleDetailHtml;
    private $subject;
    private $message;
    private $employeesSelectorHtml;

    static function create( AssessmentCycleValueObject $assessmentCycle,
                            $displayWidth)
    {
        return new EmployeeSelfAssessmentBatchInvite(   $assessmentCycle,
                                                        $displayWidth,
                                                        self::TEMPLATE_FILE);
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCycleDetailHtml($cycleDetailHtml)
    {
        $this->cycleDetailHtml = $cycleDetailHtml;
    }

    function getCycleDetailHtml()
    {
        return $this->cycleDetailHtml;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSubject($subject)
    {
        $this->subject = $subject;
    }

    function getSubject()
    {
        return $this->subject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setMessage($message)
    {
        $this->message = $message;
    }

    function getMessage()
    {
        return $this->message;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeesSelectorHtml($employeesSelectorHtml)
    {
        $this->employeesSelectorHtml = $employeesSelectorHtml;
    }

    function getEmployeesSelectorHtml()
    {
        return $this->employeesSelectorHtml;
    }

}

?>
