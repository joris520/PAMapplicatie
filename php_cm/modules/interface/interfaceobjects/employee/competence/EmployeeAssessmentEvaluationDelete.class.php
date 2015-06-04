<?php

/**
 * Description of EmployeeAssessmentEvaluationDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAssessmentEvaluationDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentEvaluationDelete.tpl';

    private $confirmQuestion;
    private $attachmentLink;

    static function createWithValueObject(  EmployeeAssessmentEvaluationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAssessmentEvaluationDelete(  $valueObject,
                                                        $displayWidth,
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
