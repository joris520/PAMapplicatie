<?php

/**
 * Description of EmployeeTargetEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeTargetEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/target/employeeTargetEdit.tpl';

    private $cancelStatusLink;
    private $endDatePicker;
    private $evaluationDatePicker;

    private $showLabel;
    private $isEditAllowedTarget;
    private $isViewAllowedEvaluation;
    private $isAddAllowedEvaluation;
    private $isEditAllowedEvaluation;

    static function createWithValueObject(  EmployeeTargetValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeTargetEdit(  $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    protected function __construct( EmployeeTargetValueObject $valueObject,
                                    $displayWidth,
                                    $templateFile)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            $templateFile);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $cancelStatusLink
    function setCancelStatusLink($cancelStatusLink)
    {
        $this->cancelStatusLink = $cancelStatusLink;
    }

    function getCancelStatusLink()
    {
        return $this->cancelStatusLink;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $endDatePicker
    function setEndDatePicker($endDatePicker)
    {
        $this->endDatePicker = $endDatePicker;
    }

    function getEndDatePicker()
    {
        return $this->endDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationDatePicker
    function setEvaluationDatePicker($evaluationDatePicker)
    {
        $this->evaluationDatePicker = $evaluationDatePicker;
    }

    function getEvaluationDatePicker()
    {
        return $this->evaluationDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $showLabel
    function setShowLabel($showLabel)
    {
        $this->showLabel = $showLabel;
    }

    function showLabel()
    {
        return $this->showLabel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isEditAllowedTarget
    function setIsEditAllowedTarget($isEditAllowedTarget)
    {
        $this->isEditAllowedTarget = $isEditAllowedTarget;
    }

    function isEditAllowedTarget()
    {
        return $this->isEditAllowedTarget;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isViewAllowedEvaluation
    function setIsViewAllowedEvaluation($isViewAllowedEvaluation)
    {
        $this->isViewAllowedEvaluation = $isViewAllowedEvaluation;
    }

    function isViewAllowedEvaluation()
    {
        return $this->isViewAllowedEvaluation;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isAddAllowedEvaluation
    function setIsAddAllowedEvaluation($isAddAllowedEvaluation)
    {
        $this->isAddAllowedEvaluation = $isAddAllowedEvaluation;
    }

    function isAddAllowedEvaluation()
    {
        return $this->isAddAllowedEvaluation;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isEditAllowedEvaluation
    function setIsEditAllowedEvaluation($isEditAllowedEvaluation)
    {
        $this->isEditAllowedEvaluation = $isEditAllowedEvaluation;
    }

    function isEditAllowedEvaluation()
    {
        return $this->isEditAllowedEvaluation;
    }
}
?>
