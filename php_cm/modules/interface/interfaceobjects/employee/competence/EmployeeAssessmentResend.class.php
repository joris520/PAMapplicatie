<?php

/**
 * Description of EmployeeAssessmentResend
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAssessmentResend extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentResend.tpl';

    private $confirmQuestion;

    static function create($displayWidth)
    {
        return new EmployeeAssessmentResend($displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $confirmQuestion
    function setConfirmQuestion($confirmQuestion)
    {
        $this->confirmQuestion = $confirmQuestion;
    }

    function getConfirmQuestion()
    {
        return $this->confirmQuestion;
    }

}

?>
