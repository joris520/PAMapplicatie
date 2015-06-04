<?php

/**
 * Description of EmployeeAssessmentViewInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAssessmentEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentEdit.tpl';

    private $assessmentDatePicker;

    private $isViewAllowedScoreStatus;
    private $isEditAllowedScoreStatus;

    private $showAssessmentNote;

    static function createWithValueObject(  EmployeeAssessmentValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAssessmentEdit(  $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentDatePicker($assessmentDatePicker)
    {
        $this->assessmentDatePicker = $assessmentDatePicker;
    }

    function getAssessmentDatePicker()
    {
        return $this->assessmentDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsViewAllowedScoreStatus($isViewAllowedScoreStatus)
    {
        $this->isViewAllowedScoreStatus = $isViewAllowedScoreStatus;
    }

    function isViewAllowedScoreStatus()
    {
        return $this->isViewAllowedScoreStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsEditAllowedScoreStatus($isEditAllowedScoreStatus)
    {
        $this->isEditAllowedScoreStatus = $isEditAllowedScoreStatus;
    }

    function isEditAllowedScoreStatus()
    {
        return $this->isEditAllowedScoreStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowAssessmentNote($showAssessmentNote)
    {
        $this->showAssessmentNote = $showAssessmentNote;
    }

    function showAssessmentNote()
    {
        return $this->showAssessmentNote;
    }

}

?>
