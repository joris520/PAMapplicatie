<?php

/**
 * Description of EmployeeAssessmentEvaluationEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAssessmentEvaluationEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentEvaluationEdit.tpl';

    private $assessmentDatePicker;
    private $assessmentEvaluationDatePicker;
    private $assessmentEvaluationStatusValues;
    private $showUpload;
    private $attachmentLink;

    static function createWithValueObject(  EmployeeAssessmentEvaluationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAssessmentEvaluationEdit(    $valueObject,
                                                        $displayWidth,
                                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentDatePicker
    function setAssessmentDatePicker($assessmentDatePicker)
    {
        $this->assessmentDatePicker = $assessmentDatePicker;
    }

    function getAssessmentDatePicker()
    {
        return $this->assessmentDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentEvaluationDatePicker
    function setAssessmentEvaluationDatePicker($assessmentEvaluationDatePicker)
    {
        $this->assessmentEvaluationDatePicker = $assessmentEvaluationDatePicker;
    }

    function getAssessmentEvaluationDatePicker()
    {
        return $this->assessmentEvaluationDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentEvaluationStatusValues
    function setAssessmentEvaluationStatusValues($assessmentEvaluationStatusValues)
    {
        $this->assessmentEvaluationStatusValues = $assessmentEvaluationStatusValues;
    }

    function getAssessmentEvaluationStatusValues()
    {
        return $this->assessmentEvaluationStatusValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $showUpload
    function setShowUpload($showUpload)
    {
        $this->showUpload = $showUpload;
    }

    function getShowUpload()
    {
        return $this->showUpload;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $attachmentLink
    function setAttachmentLink($attachmentLink)
    {
        $this->attachmentLink = $attachmentLink;
    }

    function getAttachmentLink()
    {
        return $this->attachmentLink;
    }

}

?>
